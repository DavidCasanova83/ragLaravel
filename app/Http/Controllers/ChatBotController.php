<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LLPhant\Chat\OpenAIChat;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;
use LLPhant\Embeddings\VectorStores\FileSystem\FileSystemVectorStore;
use LLPhant\OpenAIConfig;
use LLPhant\Query\SemanticSearch\QuestionAnswering;

class ChatBotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function ask(Request $request)
    {
        $question = $request->input('question');
        $answer = null;

        // Vérifier que la clé API est définie
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            return back()->withErrors('La clé API OpenAI n\'est pas définie.');
        }

        if ($question) {
            $vectorStore = new FileSystemVectorStore(storage_path('../documents-vectorStore.json'));
            $embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();

            // Créer une instance de OpenAIConfig avec la clé API
            $openAIConfig = new OpenAIConfig();
            $openAIConfig->apiKey = $apiKey;

            // Passer l'instance de OpenAIConfig à OpenAIChat
            $qa = new QuestionAnswering(
                $vectorStore,
                $embeddingGenerator,
                new OpenAIChat()
            );

            $answer = $qa->answerQuestion($question);
        }

        return view('chatbot.index', ['answer' => $answer]);
    }
}
