<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{-- Task Filters --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <select class="form-select" id="taskStatusFilter">
                        <option value="">All Status</option>
                        <option value="is_progress">In Progress</option>
                        <option value="on_hold">On Hold</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="finished">Finished</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Search tasks..." id="taskSearchInput">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" id="taskClearFilters">Clear</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i> Task
                    </button>
                </div>
            </div>

            {{-- Task Boards --}}
            <div class="row" id="tasksContainer">
                {{-- Tasks will be loaded here via AJAX --}}
            </div>
        </div>
    </div>
</div>

{{-- Task Details Modal --}}
<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="taskModalBody">
                {{-- Task details will be loaded here --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Edit Task</button>
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
$(document).ready(function() {
    const customerContactKey = '{{ $customer_contact->special_key }}';

    /* =========================
     *   TASKS SECTION
     * ========================= */
    let taskRequest = null;
    let taskSearchTimeout = null;

    // Filter functionality
    $('#taskStatusFilter, #taskPriorityFilter').on('change', function() {
        loadTasks();
    });

    $('#taskSearchInput').on('keyup', function() {
        clearTimeout(taskSearchTimeout);
        taskSearchTimeout = setTimeout(loadTasks, 500);
    });

    $('#taskClearFilters').on('click', function() {
        clearTimeout(taskSearchTimeout);
        $('#taskStatusFilter, #taskPriorityFilter').val('');
        $('#taskSearchInput').val('');
        loadTasks();
    });

    // Global function for loading tasks
    window.loadTasks = function () {
        clearTimeout(taskSearchTimeout);
        
        if (taskRequest && taskRequest.readyState !== 4) {
            taskRequest.abort();
        }

        const filters = {
            cus_contact_key: customerContactKey,
            status: $('#taskStatusFilter').val(),
            priority: $('#taskPriorityFilter').val(),
            search: $('#taskSearchInput').val()
        };

        if (!$('#tasksContainer').length) return;

        taskRequest = $.ajax({
            url: '{{ route("admin.customer.contact.tasks.data") }}',
            method: 'GET',
            data: filters,
            beforeSend: function() {
                $('#tasksContainer').html('<div class="text-center p-3">Loading tasks...</div>');
            },
            success: function (response) {
                $('#tasksContainer').html(response);
                if (typeof initializeTaskDragAndDrop === 'function') {
                    initializeTaskDragAndDrop();
                }
            },
            error: function (xhr, status) {
                if (status !== 'abort') console.error('Error loading tasks:', xhr);
            }
        });
    };

    // Task modal handling
    $(document).on('click', '.task-card', function() {
        const taskId = $(this).data('task-id');
        loadTaskDetails(taskId);
    });

    function loadTaskDetails(taskId) {
        console.log('Loading details for task ID:', taskId);
        $.ajax({
            url: '{{ route("admin.customer.contact.tasks.details") }}',
            method: 'GET',
            data: { id: taskId, cus_contact_key: customerContactKey },
            success: function(response) {
                $('#taskModalBody').html(response);
                $('#taskModal').modal('show');
            },
            error: function(xhr) {
                console.error('Error loading task details:', xhr);
            }
        });
    }

    // Drag and Drop for Tasks
    function initializeTaskDragAndDrop() {
        const sortableContainers = document.querySelectorAll('.sortable-container.task-column');

        sortableContainers.forEach(container => {
            new Sortable(container, {
                group: { name: 'tasks', pull: true, put: true },
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                filter: '.empty-column',
                draggable: '.sortable-item',

                onEnd: function(evt) {
                    const taskId = evt.item.dataset.taskId;
                    const oldStatus = evt.from.dataset.status;
                    const newStatus = evt.to.dataset.status;
                    const taskIds = Array.from(evt.to.querySelectorAll('.sortable-item'))
                        .map(item => item.dataset.taskId)
                        .filter(id => id);

                    const emptyPlaceholder = evt.to.querySelector('.empty-column');
                    if (emptyPlaceholder) emptyPlaceholder.remove();

                    updateTaskMove(taskId, oldStatus, newStatus, taskIds);
                },
                onAdd: function(evt) {
                    const emptyPlaceholder = evt.to.querySelector('.empty-column');
                    if (emptyPlaceholder) emptyPlaceholder.remove();
                },
                onRemove: function(evt) {
                    if (evt.from.children.length === 0) {
                        evt.from.innerHTML = '<div class="text-center text-muted py-4 empty-column"><small>No tasks in this status</small></div>';
                    }
                }
            });
        });
    }

    function updateTaskMove(taskId, oldStatus, newStatus, taskIds) {
        $.ajax({
            url: '{{ route("admin.customer.contact.tasks.update-move") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                task_id: taskId,
                old_status: oldStatus,
                new_status: newStatus,
                task_ids: taskIds,
                cus_contact_key: customerContactKey
            },
            success: function(response) {
                if (!response.success) loadTasks();
            },
            error: function(xhr) {
                console.error('Error updating task move:', xhr);
                loadTasks();
            }
        });
    }

});
</script>

@endpush

<style>
/* Task-specific styles */
.task-board {
    min-height: 400px;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}

.task-card {
    background: white;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 4px solid #007bff;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.task-description {
    font-size: 0.85rem;
    line-height: 1.4;
}

.task-card.regular { border-left-color: #6c757d; }
.task-card.standard { border-left-color: #007bff; }
.task-card.premium { border-left-color: #28a745; }
.task-card.exclusive { border-left-color: #ffc107; }

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

.task-meta {
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
#tasksHorizontalScroll {
    scrollbar-width: thin;
    scrollbar-color: #dee2e6 #f8f9fa;
}

#tasksHorizontalScroll::-webkit-scrollbar {
    height: 8px;
}

#tasksHorizontalScroll::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 10px;
}

#tasksHorizontalScroll::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 10px;
}

#tasksHorizontalScroll::-webkit-scrollbar-thumb:hover {
    background: #adb5bd;
}

.task-column {
    scrollbar-width: thin;
    scrollbar-color: #dee2e6 transparent;
}

.task-column::-webkit-scrollbar {
    width: 6px;
}

.task-column::-webkit-scrollbar-track {
    background: transparent;
}

.task-column::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 10px;
}

/* Project Board Styles */
.task-board {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e9ecef;
    height: 100%;
}

.task-card {
    background: white;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 4px solid #007bff;
    border: 1px solid #e9ecef;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.task-card.regular { border-left-color: #6c757d; }
.task-card.standard { border-left-color: #007bff; }
.task-card.premium { border-left-color: #28a745; }
.task-card.exclusive { border-left-color: #ffc107; }

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

.task-meta {
    font-size: 0.8rem;
    color: #6c757d;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #tasksHorizontalScroll {
        min-height: 500px;
    }
    
    .col-xl-3.col-lg-4.col-md-6 {
        min-width: 280px;
    }
    
    .task-board {
        padding: 15px;
    }
}

/* SortableJS Styles */
.sortable-ghost {
    opacity: 0.4;
    background: #f8f9fa;
}

.sortable-chosen {
    transform: rotate(5deg);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.sortable-drag {
    opacity: 0.8;
}

.sortable-item {
    cursor: grab;
    transition: all 0.2s ease;
}

.sortable-item:active {
    cursor: grabbing;
}

/* Empty column styling */
.empty-column {
    pointer-events: none;
    user-select: none;
}
</style>