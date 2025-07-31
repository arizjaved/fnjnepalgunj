@extends('layouts.admin')

@section('title', 'News Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">News Management</h1>
            <p class="text-gray-600">Manage your news articles and publications</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Add New Article</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search articles by title, content, or author..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0073b7] focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-6 py-2 rounded-lg transition-colors">
                    Search
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.news.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Articles</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $news->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Published</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $news->where('status', 'published')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Drafts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $news->where('status', 'draft')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Featured</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $news->where('is_featured', true)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- News Articles Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">All News Articles</h2>
        </div>
        
        @if($news->count() > 0)
            <div class="overflow-x-auto">
                <form id="bulk-actions-form" method="POST" action="{{ route('admin.news.bulk-action') }}">
                    @csrf
                    <div class="flex items-center justify-between p-4 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                            <label for="select-all" class="text-sm text-gray-700">Select All</label>
                        </div>
                        <div class="flex items-center space-x-2" id="bulk-actions" style="display: none;">
                            <select name="action" class="px-3 py-1 border border-gray-300 rounded text-sm">
                                <option value="">Bulk Actions</option>
                                <option value="publish">Publish Selected</option>
                                <option value="draft">Move to Draft</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-3 py-1 rounded text-sm transition-colors">
                                Apply
                            </button>
                        </div>
                    </div>
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                    <span class="sr-only">Select</span>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($news as $article)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="selected_articles[]" value="{{ $article->id }}" 
                                           class="article-checkbox rounded border-gray-300 text-[#0073b7] focus:ring-[#0073b7]">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($article->featured_image)
                                            <img src="{{ $article->featured_image_url }}" 
                                                 class="w-12 h-12 rounded-lg object-cover mr-4">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center space-x-2">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $article->title }}</p>
                                                @if($article->is_featured)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        Featured
                                                    </span>
                                                @endif
                                            </div>
                                            @if($article->excerpt)
                                                <p class="text-sm text-gray-500 truncate">{{ Str::limit($article->excerpt, 60) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($article->category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white" style="background-color: {{ $article->category->color }}">
                                            {{ $article->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">No category</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($article->status === 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($article->published_at)
                                        {{ $article->published_at->format('M d, Y') }}
                                    @else
                                        <span class="text-gray-400">Not published</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $article->creator->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.news.show', $article) }}" 
                                           class="text-blue-600 hover:text-blue-900 p-1 rounded-md hover:bg-blue-50 transition-colors"
                                           title="View Article">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.news.edit', $article) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 p-1 rounded-md hover:bg-yellow-50 transition-colors"
                                           title="Edit Article">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        @if($article->status === 'published')
                                            <a href="{{ route('news.show', $article->slug) }}" 
                                               class="text-green-600 hover:text-green-900 p-1 rounded-md hover:bg-green-50 transition-colors"
                                               title="View on Website" target="_blank">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.news.destroy', $article) }}" 
                                              method="POST" class="inline delete-form"
                                              data-article-title="{{ $article->title }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 p-1 rounded-md hover:bg-red-50 transition-colors"
                                                    title="Delete Article">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </form>
            </div>

            <!-- Pagination -->
            @if($news->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $news->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No news articles found</h3>
                <p class="text-gray-500 mb-6">Start by creating your first news article to get started.</p>
                <a href="{{ route('admin.news.create') }}" class="bg-[#0073b7] hover:bg-[#004a7f] text-white px-4 py-2 rounded-lg inline-flex items-center space-x-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Create First Article</span>
                </a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const articleCheckboxes = document.querySelectorAll('.article-checkbox');
    const bulkActionsDiv = document.getElementById('bulk-actions');
    const bulkForm = document.getElementById('bulk-actions-form');
    
    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            articleCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });
    }
    
    // Individual checkbox functionality
    articleCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.article-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === articleCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < articleCheckboxes.length;
            toggleBulkActions();
        });
    });
    
    // Show/hide bulk actions
    function toggleBulkActions() {
        const checkedCount = document.querySelectorAll('.article-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkActionsDiv.style.display = 'flex';
        } else {
            bulkActionsDiv.style.display = 'none';
        }
    }
    
    // Bulk form submission
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const selectedAction = document.querySelector('select[name="action"]').value;
            const checkedCount = document.querySelectorAll('.article-checkbox:checked').length;
            
            if (!selectedAction) {
                e.preventDefault();
                alert('Please select an action to perform.');
                return;
            }
            
            if (checkedCount === 0) {
                e.preventDefault();
                alert('Please select at least one article.');
                return;
            }
            
            let confirmMessage = '';
            switch(selectedAction) {
                case 'publish':
                    confirmMessage = `Are you sure you want to publish ${checkedCount} article(s)?`;
                    break;
                case 'draft':
                    confirmMessage = `Are you sure you want to move ${checkedCount} article(s) to draft?`;
                    break;
                case 'delete':
                    confirmMessage = `Are you sure you want to delete ${checkedCount} article(s)? This action cannot be undone.`;
                    break;
            }
            
            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
        });
    }
    
    // Individual delete forms - handle confirmation properly
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const articleTitle = this.dataset.articleTitle;
            if (confirm(`Are you sure you want to delete "${articleTitle}"? This action cannot be undone.`)) {
                this.submit();
            }
        });
    });
    
    // Auto-refresh functionality (optional)
    let refreshInterval;
    const refreshButton = document.createElement('button');
    refreshButton.innerHTML = `
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
    `;
    refreshButton.className = 'text-gray-500 hover:text-gray-700 p-1 rounded-md hover:bg-gray-100 transition-colors';
    refreshButton.title = 'Refresh';
    refreshButton.type = 'button';
    
    refreshButton.addEventListener('click', function() {
        window.location.reload();
    });
    
    // Add refresh button to header
    const headerDiv = document.querySelector('.flex.justify-between.items-center');
    if (headerDiv) {
        const buttonContainer = headerDiv.querySelector('div') || headerDiv;
        buttonContainer.appendChild(refreshButton);
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + A to select all
        if ((e.ctrlKey || e.metaKey) && e.key === 'a' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
                selectAllCheckbox.dispatchEvent(new Event('change'));
            }
        }
        
        // Escape to clear selection
        if (e.key === 'Escape') {
            articleCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            }
            toggleBulkActions();
        }
    });
    
    // Status badge click to filter
    document.querySelectorAll('.inline-flex.items-center.px-2\\.5').forEach(badge => {
        badge.style.cursor = 'pointer';
        badge.addEventListener('click', function() {
            const status = this.textContent.trim().toLowerCase();
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('status', status);
            window.location.href = currentUrl.toString();
        });
    });
});
</script>
@endsection