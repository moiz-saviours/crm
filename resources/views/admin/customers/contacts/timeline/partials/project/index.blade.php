
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- Project Filters --}}
            <div class="row mb-4">
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="isprogress">In Progress</option>
                        <option value="on hold">On Hold</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="finished">Finished</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="valueFilter">
                        <option value="">All Values</option>
                        <option value="regular">Regular</option>
                        <option value="standard">Standard</option>
                        <option value="premium">Premium</option>
                        <option value="exclusive">Exclusive</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search projects..." id="searchInput">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" id="clearFilters">Clear</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i> Project
                    </button>
                </div>
            </div>

            {{-- Project Boards --}}
            <div class="row" id="projectsContainer">
                {{-- Projects will be loaded here via AJAX --}}
            </div>
        </div>
    </div>
</div>

{{-- Project Details Modal --}}
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">Project Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="projectModalBody">
                {{-- Project details will be loaded here --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Edit Project</button>
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
$(document).ready(function() {
    const customerId = '{{ $customer_contact->id }}';
    loadProjects();

    // Filter functionality
    $('#statusFilter, #valueFilter, #searchInput').on('change keyup', function() {
        loadProjects();
    });

    $('#clearFilters').on('click', function() {
        $('#statusFilter, #valueFilter').val('');
        $('#searchInput').val('');
        loadProjects();
    });

    function loadProjects() {
        console.log('Loading projects with filters...');
        const filters = {
            customer_id: customerId,
            status: $('#statusFilter').val(),
            value: $('#valueFilter').val(),
            search: $('#searchInput').val()
        };

        $.ajax({
            url: '{{ route("admin.customer.contact.projects.data") }}',
            method: 'GET',
            data: filters,
            success: function(response) {
                $('#projectsContainer').html(response);
            },
            error: function(xhr) {
                console.error('Error loading projects:', xhr);
            }
        });
    }

    // Project modal handling
    $(document).on('click', '.project-card', function() {
        const projectId = $(this).data('project-id');
        loadProjectDetails(projectId);
    });

    function loadProjectDetails(projectId) {
        $.ajax({
            url: '{{ route("admin.customer.contact.projects.details") }}',
            method: 'GET',
            data: { 
                id: projectId,
                customer_id: customerId
            },
            success: function(response) {
                $('#projectModalBody').html(response);
                $('#projectModal').modal('show');
            },
            error: function(xhr) {
                console.error('Error loading project details:', xhr);
            }
        });
    }
});
</script>

@endpush
<style>
.project-board {
    min-height: 400px;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}

.project-card {
    background: white;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 4px solid #007bff;
}

.project-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.project-card.regular { border-left-color: #6c757d; }
.project-card.standard { border-left-color: #007bff; }
.project-card.premium { border-left-color: #28a745; }
.project-card.exclusive { border-left-color: #ffc107; }

.status-badge {
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 12px;
}

.progress {
    height: 8px;
    margin: 10px 0;
}

.attachment-badge, .member-badge {
    font-size: 0.7rem;
    margin-right: 5px;
}

.project-meta {
    font-size: 0.85rem;
    color: #6c757d;
}

.team-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    margin-right: 5px;
}
/* Horizontal Scroll Styles */
#projectsHorizontalScroll {
    scrollbar-width: thin;
    scrollbar-color: #dee2e6 #f8f9fa;
}

#projectsHorizontalScroll::-webkit-scrollbar {
    height: 8px;
}

#projectsHorizontalScroll::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 10px;
}

#projectsHorizontalScroll::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 10px;
}

#projectsHorizontalScroll::-webkit-scrollbar-thumb:hover {
    background: #adb5bd;
}

.project-column {
    scrollbar-width: thin;
    scrollbar-color: #dee2e6 transparent;
}

.project-column::-webkit-scrollbar {
    width: 6px;
}

.project-column::-webkit-scrollbar-track {
    background: transparent;
}

.project-column::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 10px;
}

/* Project Board Styles */
.project-board {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e9ecef;
    height: 100%;
}

.project-card {
    background: white;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 4px solid #007bff;
    border: 1px solid #e9ecef;
}

.project-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.project-card.regular { border-left-color: #6c757d; }
.project-card.standard { border-left-color: #007bff; }
.project-card.premium { border-left-color: #28a745; }
.project-card.exclusive { border-left-color: #ffc107; }

.status-badge {
    font-size: 0.7rem;
    padding: 4px 8px;
    border-radius: 12px;
}

.progress {
    height: 6px;
    margin: 10px 0;
    background-color: #e9ecef;
    border-radius: 3px;
}

.attachment-badge, .member-badge {
    font-size: 0.65rem;
    margin-right: 5px;
    padding: 3px 6px;
}

.project-meta {
    font-size: 0.8rem;
    color: #6c757d;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #projectsHorizontalScroll {
        min-height: 500px;
    }
    
    .col-xl-3.col-lg-4.col-md-6 {
        min-width: 280px;
    }
    
    .project-board {
        padding: 15px;
    }
}
</style>


{{-- <div id="projects-section">
    <div class="text-center py-4 no-projects-placeholder">
        <i class="fa fa-folder-open text-muted" style="font-size: 32px;"></i>
        <p class="mt-2 text-muted">No projects available yet.</p>
        <small class="text-secondary">
            Once you create or assign projects, they’ll appear here.
        </small>
    </div>
</div> --}}
