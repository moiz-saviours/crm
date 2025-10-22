<div class="container-fluid">
    {{-- Horizontal Scroll Container --}}
    <div class="row flex-nowrap overflow-auto pb-3" id="projectsHorizontalScroll" style="min-height: 600px;">
        @foreach(['isprogress' => 'In Progress', 'on hold' => 'On Hold', 'cancelled' => 'Cancelled', 'finished' => 'Finished'] as $status => $statusLabel)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4" style="min-width: 320px;">
            <div class="project-board h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0">{{ $statusLabel }}</h6>
                    <span class="badge bg-light text-dark">{{ $projects->where('project_status', $status)->count() }}</span>
                </div>
                
                <div class="project-column" style="max-height: 500px; overflow-y: auto;">
                    @foreach($projects->where('project_status', $status) as $project)
                    <div class="project-card {{ $project->value }} mb-3" data-project-id="{{ $project->id }}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0 text-truncate" style="max-width: 180px;">{{ $project->label }}</h6>
                            <span class="badge status-badge bg-{{ $project->getStatusColor() }}">
                                {{ ucfirst($project->value) }}
                            </span>
                        </div>
                        
                        <p class="project-meta mb-2">
                            <small class="text-truncate d-block">
                                {{ $project->brand_key ?? 'No Brand' }} • {{ $project->team_key ?? 'No Team' }}
                            </small>
                        </p>
                        
                        <div class="progress mb-2">
                            <div class="progress-bar bg-{{ $project->getProgressColor() }}" 
                                 role="progressbar" 
                                 style="width: {{ $project->progress }}%"
                                 aria-valuenow="{{ $project->progress }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="project-meta">
                                <small>
                                    <i class="fas fa-calendar"></i> 
                                    {{ \Carbon\Carbon::parse($project->deadline)->format('M d') }}
                                </small>
                            </div>
                            <div class="d-flex">
                                <span class="badge attachment-badge bg-light text-dark">
                                    <i class="fas fa-paperclip"></i> {{ $project->attachments_count ?? 0 }}
                                </span>
                                <span class="badge member-badge bg-light text-dark">
                                    <i class="fas fa-users"></i> {{ $project->members_count ?? 0 }}
                                </span>
                            </div>
                        </div>
                        
                        @if($project->tags && is_array($project->tags) && count($project->tags) > 0)
                        <div class="mt-2">
                            @foreach(array_slice($project->tags, 0, 3) as $tag)
                            <span class="badge bg-light text-dark me-1 mb-1">{{ $tag }}</span>
                            @endforeach
                            @if(count($project->tags) > 3)
                            <span class="badge bg-secondary">+{{ count($project->tags) - 3 }}</span>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                    
                    @if($projects->where('project_status', $status)->count() === 0)
                    <div class="text-center text-muted py-4">
                        <small>No projects in this status</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>