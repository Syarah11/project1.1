<?php

namespace App\Services;

use App\Models\Iklan;
use Illuminate\Support\Facades\Storage;

class IklanService
{
    public function getAllIklans($perPage = 10, $filters = [])
    {
        $query = Iklan::with('user');

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['position'])) {
            $query->where('position', $filters['position']);
        }

        return $query->orderBy('priority', 'asc')->paginate($perPage);
    }

    public function getIklanById($id)
    {
        return Iklan::with('user')->findOrFail($id);
    }

    public function createIklan(array $data)
    {
        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = $data['thumbnail']->store('iklans', 'public');
        }
        // SET USER ID DARI USER LOGIN
    //$data['user_id'] = Auth::id();

        return Iklan::create($data);
    }

    public function updateIklan($id, array $data)
    {
        $iklan = Iklan::findOrFail($id);

        if (isset($data['thumbnail'])) {
            if ($iklan->thumbnail) {
                Storage::disk('public')->delete($iklan->thumbnail);
            }
            $data['thumbnail'] = $data['thumbnail']->store('iklans', 'public');
        }
        

        $iklan->update($data);
        return $iklan->fresh();
    }

    public function deleteIklan($id)
    {
        $iklan = Iklan::findOrFail($id);

        if ($iklan->thumbnail) {
            Storage::disk('public')->delete($iklan->thumbnail);
        }

        return $iklan->delete();
    }

    public function getActiveIklans($position = null)
    {
        $query = Iklan::where('status', 'active');

        if ($position) {
            $query->where('position', $position);
        }

        return $query->orderBy('priority', 'asc')->get();
    }
}