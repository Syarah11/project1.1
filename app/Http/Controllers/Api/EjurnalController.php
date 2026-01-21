public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'images' => 'required|array',
        'images.*' => 'image|max:2048',
    ]);

    $ejurnal = Ejurnal::create([
        'user_id' => auth()->id(), // 🔐 WAJIB
        'title' => $validated['title'],
        'description' => $validated['description'],
    ]);

    foreach ($request->file('images') as $image) {
        $path = $image->store('ejurnals', 'public');
        EjurnalImage::create([
            'ejurnal_id' => $ejurnal->id,
            'image' => $path
        ]);
    }

    return response()->json([
        'success' => true,
        'data' => $ejurnal
    ], 201);
}
