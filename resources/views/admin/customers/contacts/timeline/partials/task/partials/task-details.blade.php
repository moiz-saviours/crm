@if($task)
<div class="row">
    <div class="col-md-8">
        {{-- Basic Info --}}
        <div class="mb-4">
            <h4>{{ $task->label }}</h4>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-{{ $task->getStatusColor() }}">
                    {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                </span>
                @if($task->project)
                <span class="badge bg-info">
                    Project: {{ $task->project->label }}
                </span>
                @endif
            </div>
            <p class="text-muted">{{ $task->description }}</p>
        </div>

        {{-- Project Info --}}
        @if($task->project)
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="card-title">Project Information</h6>
                <p class="mb-1"><strong>Project:</strong> {{ $task->project->label }}</p>
                <p class="mb-1"><strong>Project Status:</strong> 
                    <span class="badge bg-{{ $task->project->getStatusColor() }}">
                        {{ ucfirst($task->project->project_status) }}
                    </span>
                </p>
                <p class="mb-0"><strong>Project Progress:</strong> {{ $task->project->progress }}%</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        {{-- Task Details --}}
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Task Details</h6>
                <p class="mb-1"><strong>Task ID:</strong> {{ $task->special_key ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Created:</strong> {{ $task->created_at->format('M d, Y') }}</p>
                <p class="mb-0"><strong>Last Updated:</strong> {{ $task->updated_at->format('M d, Y') }}</p>
            </div>
        </div>

        {{-- Attachments --}}
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Attachments ({{ $task->attachments_count ?? 0 }})</h6>
                @if($task->attachments && $task->attachments->count() > 0)
                    @foreach($task->attachments as $attachment)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <i class="fas fa-file text-muted me-2"></i>
                            <small>{{ $attachment->file_name }}</small>
                        </div>
                        <small class="text-muted">{{ $task->formatFileSize($attachment->file_size) }}</small>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">No attachments</p>
                @endif
            </div>
        </div>

        {{-- Members --}}
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Team Members ({{ $task->members_count ?? 0 }})</h6>
                @if($task->members && $task->members->count() > 0)
                    @foreach($task->members as $member)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="team-avatar">
                                {{ substr($member->role, 0, 1) }}
                            </div>
                            <span class="ms-2">{{ $member->role }}</span>
                        </div>
                        <span class="badge bg-{{ $member->is_active ? 'success' : 'secondary' }}">
                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0">No team members</p>
                @endif
            </div>
        </div>
    </div>
</div>
@else
<div class="text-center py-4">
    <p class="text-muted">Task not found</p>
</div>
@endif