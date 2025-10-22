@if($project)
<div class="row">
    <div class="col-md-8">
        {{-- Basic Info --}}
        <div class="mb-4">
            <h4>{{ $project->label }}</h4>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-{{ $project->getStatusColor() }}">
                    {{ ucfirst($project->project_status) }}
                </span>
                <span class="badge bg-{{ $project->getValueColor() }}">
                    {{ ucfirst($project->value) }}
                </span>
                <span class="badge bg-secondary">{{ $project->type }}</span>
            </div>
            <p class="text-muted">{{ $project->description }}</p>
        </div>

        {{-- Progress --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
                <span>Project Progress</span>
                <span>{{ $project->progress }}%</span>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-{{ $project->getProgressColor() }}" 
                     style="width: {{ $project->progress }}%"></div>
            </div>
        </div>

        {{-- Timeline --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <strong>Start Date:</strong>
                <p class="text-muted">{{ \Carbon\Carbon::parse($project->start_date)->format('M d, Y') }}</p>
            </div>
            <div class="col-md-6">
                <strong>Deadline:</strong>
                <p class="text-muted {{ $project->deadline < now() ? 'text-danger' : '' }}">
                    {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                </p>
            </div>
        </div>

        {{-- Financial --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <strong>Bill Type:</strong>
                <p class="text-muted">{{ ucfirst($project->bill_type) }}</p>
            </div>
            <div class="col-md-6">
                <strong>Total Rate:</strong>
                <p class="text-muted">${{ number_format($project->total_rate, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Team & Brand --}}
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Team & Brand</h6>
                <p class="mb-1"><strong>Brand:</strong> {{ $project->brand_key ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Team:</strong> {{ $project->team_key ?? 'N/A' }}</p>
                <p class="mb-0"><strong>Customer Key:</strong> {{ $project->customer_special_key ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Attachments --}}
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title">Attachments ({{ $project->attachments_count ?? 0 }})</h6>
                @if($project->attachments && $project->attachments->count() > 0)
                    @foreach($project->attachments as $attachment)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <i class="fas fa-file text-muted me-2"></i>
                            <small>{{ $attachment->file_name }}</small>
                        </div>
                        <small class="text-muted">{{ $project->formatFileSize($attachment->file_size) }}</small>
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
                <h6 class="card-title">Team Members ({{ $project->members_count ?? 0 }})</h6>
                @if($project->members && $project->members->count() > 0)
                    @foreach($project->members as $member)
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

{{-- Tags --}}
@if($project->tags)
<div class="row mt-4">
    <div class="col-12">
        <strong>Tags:</strong>
        @foreach($project->tags as $tag)
        <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
        @endforeach
    </div>
</div>
@endif
@else
<div class="text-center py-4">
    <p class="text-muted">Project not found</p>
</div>
@endif