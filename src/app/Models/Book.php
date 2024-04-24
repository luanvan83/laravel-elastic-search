<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Author;
use Elastic\ScoutDriverPlus\Searchable;

class Book extends Model
{
    use HasFactory;
    // use ElasticquentTrait;
    use Searchable;

    protected $beSearchable = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['publisher', 'title', 'summary'];

     /**
     * The elasticsearch settings.
     *
     * @var array
     */
    protected $indexSettings = [
        'analysis' => [
            'char_filter' => [
                'replace' => [
                    'type' => 'mapping',
                    'mappings' => [
                        '&=> and '
                    ],
                ],
            ],
            'filter' => [
                'word_delimiter' => [
                    'type' => 'word_delimiter',
                    'split_on_numerics' => false,
                    'split_on_case_change' => true,
                    'generate_word_parts' => true,
                    'generate_number_parts' => true,
                    'catenate_all' => true,
                    'preserve_original' => true,
                    'catenate_numbers' => true,
                ]
            ],
            'analyzer' => [
                'default' => [
                    'type' => 'custom',
                    'char_filter' => [
                        'html_strip',
                        'replace',
                    ],
                    'tokenizer' => 'whitespace',
                    'filter' => [
                        'lowercase',
                        'word_delimiter',
                    ],
                ],
            ],
        ],
    ];

    protected $mappingProperties = array(
        'title' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
        'publisher' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
        'summary' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
        'authors' => [

        ]
    );

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'books_index';
    }

    public function toSearchableArray()
    {
        // Customize the data to be indexed
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'publisher' => $this->publisher,
            'authors' => $this->authors->map(function ($author) {
                return $author->only('name');
            }),
        ];
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->beSearchable;
    }

    public function setSearchable($searchable) {
        $this->beSearchable = $searchable;
    }
}
