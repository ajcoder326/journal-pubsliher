<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $headerMenus = Menu::where('location', 'header')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get();

        $footerMenus = Menu::where('location', 'footer')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->get();

        return view('admin.menus.index', compact('headerMenus', 'footerMenus'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('sort_order')->get();
        return view('admin.menus.create', compact('parentMenus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:255',
            'location' => 'required|in:header,footer',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'icon' => 'nullable|string|max:100',
            'target' => 'in:_self,_blank',
        ]);

        $validated['is_active'] = $request->has('is_active');
        Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu item created.');
    }

    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('sort_order')->get();
        return view('admin.menus.edit', compact('menu', 'parentMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:255',
            'location' => 'required|in:header,footer',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'icon' => 'nullable|string|max:100',
            'target' => 'in:_self,_blank',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu item updated.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu item deleted.');
    }

    /**
     * Update sort order via AJAX
     */
    public function reorder(Request $request)
    {
        $request->validate(['items' => 'required|array']);

        foreach ($request->items as $index => $id) {
            Menu::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
