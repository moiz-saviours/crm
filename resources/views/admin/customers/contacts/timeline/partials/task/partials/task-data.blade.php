<div class="container-fluid">
    <div class="row flex-nowrap overflow-auto pb-3" id="tasksHorizontalScroll" style="min-height: 600px;">
        @foreach(['is_progress' => 'In Progress', 'on_hold' => 'On Hold', 'cancelled' => 'Cancelled', 'finished' => 'Finished'] as $status => $statusLabel)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4" style="min-width: 320px;">
            <div class="task-board h-100" data-status="{{ $status }}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0">{{ $statusLabel }}</h6>
                    <span class="badge bg-light text-dark">{{ $tasks->where('task_status', $status)->count() }}</span>
                </div>
                
                <div class="task-column sortable-container" id="task-column-{{ $status }}" data-status="{{ $status }}">
                    @foreach($tasks->where('task_status', $status) as $task)
                    <div class="task-card mb-3 sortable-item" data-task-id="{{ $task->id }}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0 text-truncate" style="max-width: 180px;">{{ $task->label }}</h6>
                            <span class="badge status-badge bg-{{ $task->getStatusColor() }}">
                                {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                            </span>
                        </div>
                        
                        @if($task->project)
                        <p class="task-meta mb-2">
                            <small class="text-truncate d-block">
                                <i class="fas fa-project-diagram"></i> {{ $task->project->label }}
                            </small>
                        </p>
                        @endif
                        
                        @if($task->description)
                        <p class="task-description small text-muted mb-2">
                            {{ Str::limit($task->description, 100) }}
                        </p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="task-meta">
                                <small>
                                    <i class="fas fa-calendar"></i> 
                                    {{ $task->created_at->format('M d') }}
                                </small>
                            </div>
                            <div class="d-flex">
                                <span class="badge attachment-badge bg-light text-dark">
                                    <i class="fas fa-paperclip"></i> {{ $task->attachments_count ?? 0 }}
                                </span>
                                <span class="badge member-badge bg-light text-dark">
                                    <i class="fas fa-users"></i> {{ $task->members_count ?? 0 }}
                                </span>
                            </div>
                        </div>
                        
                        @if($task->members && $task->members->count() > 0)
                        <div class="mt-2">
                            @foreach($task->members->take(3) as $member)
                            <span class="badge bg-primary me-1 mb-1">{{ $member->role }}</span>
                            @endforeach
                            @if($task->members->count() > 3)
                            <span class="badge bg-secondary">+{{ $task->members->count() - 3 }}</span>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                    
                    @if($tasks->where('task_status', $status)->count() === 0)
                    <div class="text-center text-muted py-4 empty-column">
                        <small>No tasks in this status</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>