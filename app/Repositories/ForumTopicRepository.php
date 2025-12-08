<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\ForumTopicRepositoryInterface;
use App\Models\ForumTopic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

readonly class ForumTopicRepository extends AbstractRepository implements ForumTopicRepositoryInterface
{
    public function getModel(): Model
    {
        return new ForumTopic;
    }

    public function paginate(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->getQuery()
            ->with(['user', 'category', 'likes'])
            ->withCount('posts');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category']) && $filters['category'] !== 'all') {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('name', $filters['category']);
            });
        }

        if (!empty($filters['status'])) {
            if ($filters['status'] === 'resolved') {
                $query->where('is_resolved', true);
            } elseif ($filters['status'] === 'unresolved') {
                $query->where('is_resolved', false);
            }
        }

        $sortBy = $filters['sort_by'] ?? 'recent';
        switch ($sortBy) {
            case 'popular':
                $query->orderByDesc('views_count');
                break;
            case 'unanswered':
                $query->orderBy('posts_count', 'asc');
                break;
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $page = $filters['page'] ?? 1;
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function findWithRelations(int $id): ForumTopic
    {
        return $this->getQuery()
            ->with(['user', 'category', 'likes'])
            ->withCount('posts')
            ->findOrFail($id);
    }

    public function create(array $data): ForumTopic
    {
        return $this->getModel()->create($data);
    }

    public function incrementViews(int $id): void
    {
        $this->getQuery()
            ->where('id', $id)
            ->increment('views_count');
    }
}
