<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RagService;
use App\Services\GeminiService;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class RagChatController extends Controller
{
    protected $rag;
    protected $gemini;

    public function __construct(RagService $rag, GeminiService $gemini)
    {
        $this->rag = $rag;
        $this->gemini = $gemini;
    }

    public function index()
    {
        return view('admin.ai-assistant');
    }

    public function ask(Request $request)
    {
        $request->validate(['question' => 'required|string']);

        $answer = $this->rag->ask($request->question);

        return response()->json([
            'answer' => $answer,
        ]);
    }

    public function generatePage(Request $request)
    {
        $request->validate(['prompt' => 'required|string']);

        $schema = [
            'title' => 'Заглавие на страницата',
            'content' => 'HTML съдържание',
            'slug' => 'url-friendly текст',
            'excerpt' => 'кратко описание',
            'template' => 'default',
        ];

        $prompt = "Генерирай съдържание за нова страница въз основа на: " . $request->prompt;
        $json = $this->gemini->generateStructured($prompt, $schema);

        if (!$json) {
            return response()->json(['error' => 'Неуспешно генериране. Проверете API ключа или опитайте отново.'], 422);
        }

        $language = Language::where('is_default', true)->first();
        if (!$language) {
            return response()->json(['error' => 'Няма зададен default език. Създайте език и го маркирайте като default.'], 422);
        }

        $page = Page::create([
            'template' => $json['template'] ?? 'default',
            'is_active' => true,
        ]);

        PageTranslation::create([
            'page_id' => $page->id,
            'language_id' => $language->id,
            'title' => $json['title'],
            'slug' => $json['slug'] ?? Str::slug($json['title']),
            'excerpt' => $json['excerpt'] ?? null,
            'content' => $json['content'] ?? '',
        ]);

        return response()->json([
            'success' => true,
            'page_id' => $page->id,
            'edit_url' => route('admin.pages.edit', $page->id),
        ]);
    }

    /**
     * Генерира нова секция от AI
     */
    public function generateSection(Request $request)
    {
        $request->validate(['prompt' => 'required|string']);

        // Списък с валидни типове секции
        $validTypes = ['hero', 'features', 'testimonials', 'cta', 'text', 'how-it-works', 'team', 'faq', 'portfolio', 'pricing'];

        $schema = [
            'type' => 'тип на секцията (hero, features, testimonials, cta, text, how-it-works, team, faq, portfolio, pricing)',
            'title' => 'Заглавие на секцията',
            'subtitle' => 'Подзаглавие (по желание)',
            'data' => [
                'button_text' => 'Текст на бутона (ако има)',
                'button_url' => 'URL на бутона (ако има)',
                'image' => 'път до изображение (по желание)',
                // Може да добавите други полета според типа
            ]
        ];

        $prompt = "Генерирай съдържание за нова секция въз основа на: " . $request->prompt;
        $json = $this->gemini->generateStructured($prompt, $schema);

        if (!$json) {
            return response()->json(['error' => 'Неуспешно генериране на секция.'], 422);
        }

        // Проверка дали типът е валиден
        if (!in_array($json['type'], $validTypes)) {
            $json['type'] = 'text'; // fallback
        }

        $language = Language::where('is_default', true)->first();
        if (!$language) {
            return response()->json(['error' => 'Няма зададен default език.'], 422);
        }

        $section = Section::create([
            'type' => $json['type'],
            'is_active' => true,
        ]);

        SectionTranslation::create([
            'section_id' => $section->id,
            'language_id' => $language->id,
            'title' => $json['title'] ?? null,
            'subtitle' => $json['subtitle'] ?? null,
            'data' => $json['data'] ?? [],
        ]);

        return response()->json([
            'success' => true,
            'section_id' => $section->id,
            'edit_url' => route('admin.sections.edit', $section->id),
        ]);
    }

    public function reindex()
    {
        Artisan::queue('rag:index');
        return response()->json(['message' => 'Индексирането стартира на заден план.']);
    }
}