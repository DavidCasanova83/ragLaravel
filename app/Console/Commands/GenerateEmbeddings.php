<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LLPhant\Embeddings\DataReader\FileDataReader;
use LLPhant\Embeddings\DocumentSplitter\DocumentSplitter;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;
use LLPhant\Embeddings\VectorStores\FileSystem\FileSystemVectorStore;

class GenerateEmbeddings extends Command
{
    protected $signature = 'generate:embeddings';
    protected $description = 'Genere les embeddings';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $this->info('Hello ! Nous allons Générer les embeddings de vos données.');

        $apiKey = env('OPENAI_API_KEY');
        $this->info('OPENAI_API_KEY: ' . $apiKey);

        // Assurez-vous que la variable est définie
        if (!$apiKey) {
            $this->error('La clé API OpenAI n\'est pas définie.');
            return Command::FAILURE;
        }


        $dataReader = new FileDataReader(public_path('alice.md'));
        $documents = $dataReader->getDocuments();

        $splittedDocuments = DocumentSplitter::splitDocuments($documents, 500);

        $embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();
        $embeddedDocuments = $embeddingGenerator->embedDocuments($splittedDocuments);

        $vectorStore = new FileSystemVectorStore();
        $vectorStore->addDocuments($embeddedDocuments);

        $this->info('Les embeddings ont été générés avec succès !');
    }
}
