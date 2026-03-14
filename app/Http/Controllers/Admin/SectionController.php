<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Language;
use App\Models\SectionTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    /**
     * Списък на всички секции.
     */
    public function index()
    {
        $sections = Section::orderBy('sort_order')->get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Показва форма за създаване на нова секция.
     */
    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $types = $this->getTypes();
        return view('admin.sections.create', compact('languages', 'types'));
    }

    /**
     * Записва нова секция в базата.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:' . implode(',', array_keys($this->getTypes())),
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $section = Section::create([
            'type' => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        $languages = Language::where('is_active', true)->get();

        foreach ($languages as $language) {
            $transData = $request->input($language->code, []);

            // Обработка на специфичните за типа данни
            $data = $this->processDataForType($request->type, $transData, $language->code);

            // Обработка на качени снимки
            $data = $this->handleImageUploads($request, $language->code, $data);

            SectionTranslation::create([
                'section_id' => $section->id,
                'language_id' => $language->id,
                'title' => $transData['title'] ?? null,
                'subtitle' => $transData['subtitle'] ?? null,
                'data' => $data,
            ]);
        }

        return redirect()->route('admin.sections.index')->with('success', 'Section created successfully.');
    }

    /**
     * Показва форма за редактиране на секция.
     */
    public function edit($id)
    {
        $section = Section::with('translations')->findOrFail($id);
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $types = $this->getTypes();
        return view('admin.sections.edit', compact('section', 'languages', 'types'));
    }

    /**
     * Обновява секция в базата.
     */
    public function update(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        $request->validate([
            'type' => 'required|in:' . implode(',', array_keys($this->getTypes())),
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $section->update([
            'type' => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        $languages = Language::where('is_active', true)->get();

        foreach ($languages as $language) {
            $transData = $request->input($language->code, []);
            $translation = SectionTranslation::where('section_id', $section->id)
                ->where('language_id', $language->id)
                ->first();

            $data = $translation->data ?? [];

            // Актуализиране на данните според типа
            $data = $this->processDataForType($request->type, $transData, $language->code, $data);

            // Обработка на качени снимки (заместване на стари)
            $data = $this->handleImageUploads($request, $language->code, $data, $translation);

            SectionTranslation::updateOrCreate(
                [
                    'section_id' => $section->id,
                    'language_id' => $language->id,
                ],
                [
                    'title' => $transData['title'] ?? null,
                    'subtitle' => $transData['subtitle'] ?? null,
                    'data' => $data,
                ]
            );
        }

        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully.');
    }

    /**
     * Изтрива секция.
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        // Изтриване на свързаните снимки
        foreach ($section->translations as $translation) {
            if ($translation->data && isset($translation->data['images'])) {
                foreach ($translation->data['images'] as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        $section->delete();

        return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully.');
    }

    /**
     * Връща списък с наличните типове секции.
     */
    private function getTypes()
    {
        return [
            'hero' => 'Hero Banner',
            'features' => 'Features',
            'testimonials' => 'Testimonials',
            'cta' => 'Call to Action',
            'text' => 'Text Block',
            'how-it-works' => 'How It Works',
            'team' => 'Team',
            'faq' => 'FAQ',
            'portfolio' => 'Portfolio / Gallery',
            'pricing' => 'Pricing',
        ];
    }

    /**
     * Обработва данните според типа секция.
     */
    private function processDataForType($type, $transData, $langCode, $existingData = [])
    {
        $data = $existingData;

        switch ($type) {
            case 'features':
                $data['features'] = $this->processRepeater($transData, 'features');
                break;
            case 'testimonials':
                $data['testimonials'] = $this->processRepeater($transData, 'testimonials');
                break;
            case 'how-it-works':
                $data['steps'] = $this->processRepeater($transData, 'steps');
                break;
            case 'team':
                $data['members'] = $this->processRepeater($transData, 'members');
                break;
            case 'faq':
                $data['faq_items'] = $this->processRepeater($transData, 'faq_items');
                break;
            case 'portfolio':
                $data['items'] = $this->processRepeater($transData, 'items');
                break;
            case 'pricing':
                $data['plans'] = $this->processRepeater($transData, 'plans');
                break;
            default:
                // Други типове нямат повтарящи се елементи
                break;
        }

        // Общи полета (бутон, линк и т.н.)
        if (isset($transData['button_text'])) {
            $data['button_text'] = $transData['button_text'];
        }
        if (isset($transData['button_url'])) {
            $data['button_url'] = $transData['button_url'];
        }
        if (isset($transData['image'])) {
            // image ще бъде обработено отделно от handleImageUploads
        }

        return $data;
    }

    /**
     * Обработва повтарящи се елементи (repeater) от формата.
     */
    private function processRepeater($transData, $fieldName)
    {
        $items = [];
        if (isset($transData[$fieldName]) && is_array($transData[$fieldName])) {
            foreach ($transData[$fieldName] as $index => $item) {
                // Премахваме празните редове
                if (!empty(array_filter($item))) {
                    $items[] = $item;
                }
            }
        }
        return $items;
    }

    /**
     * Обработва качването на снимки.
     */
    private function handleImageUploads(Request $request, $langCode, $data, $translation = null)
    {
        if ($request->hasFile($langCode . '.image')) {
            // Изтриване на старата снимка
            if ($translation && isset($translation->data['image'])) {
                Storage::disk('public')->delete($translation->data['image']);
            }
            $path = $request->file($langCode . '.image')->store('sections', 'public');
            $data['image'] = $path;
        } elseif ($translation && isset($translation->data['image']) && !isset($data['image'])) {
            // Запазваме старата снимка, ако не е качена нова
            $data['image'] = $translation->data['image'];
        }

        // Обработка на снимки в repeater полета (напр. членове на екипа)
        $repeaterFields = ['features', 'testimonials', 'steps', 'members', 'items', 'plans'];
        foreach ($repeaterFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                foreach ($data[$field] as $i => $item) {
                    $fileKey = $langCode . '.' . $field . '.' . $i . '.image';
                    if ($request->hasFile($fileKey)) {
                        // Изтриване на стара снимка, ако има
                        if (isset($item['image']) && Storage::disk('public')->exists($item['image'])) {
                            Storage::disk('public')->delete($item['image']);
                        }
                        $path = $request->file($fileKey)->store('sections', 'public');
                        $data[$field][$i]['image'] = $path;
                    } elseif (isset($item['image']) && !$request->hasFile($fileKey)) {
                        // Запазваме старата
                        // вече си е там
                    }
                }
            }
        }

        return $data;
    }
}