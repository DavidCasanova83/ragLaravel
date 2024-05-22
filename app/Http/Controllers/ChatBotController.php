<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LLPhant\Chat\OpenAIChat;
use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;
use LLPhant\Embeddings\VectorStores\FileSystem\FileSystemVectorStore;
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

        if ($question) {
            $vectorStore = new FileSystemVectorStore(storage_path('../documents-vectorStore.json'));
            $embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();

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
