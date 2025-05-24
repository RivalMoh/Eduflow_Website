/**
 * Tasks Management Script
 * Handles all task-related frontend functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const taskForm = document.getElementById('task-form');
    const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
    const taskModalTitle = document.getElementById('taskModalLabel');
    const taskIdInput = document.getElementById('task-id');
    const taskTitleInput = document.getElementById('task-title');
    const taskDescriptionInput = document.getElementById('task-description');
    const taskStatusInput = document.getElementById('task-status');
    const taskPriorityInput = document.getElementById('task-priority');
    const taskDueDateInput = document.getElementById('task-due-date');
    
    // Status columns for drag and drop
    const statusColumns = {
        'todo': document.querySelector('.kanban-column[data-status="todo"] .kanban-column-body'),
        'in_progress': document.querySelector('.kanban-column[data-status="in_progress"] .kanban-column-body'),
        'in_review': document.querySelector('.kanban-column[data-status="in_review"] .kanban-column-body'),
        'done': document.querySelector('.kanban-column[data-status="done"] .kanban-column-body')
    };
    
    // Initialize drag and drop
    initializeDragAndDrop();
    
    // Event Listeners
    if (taskForm) {
        taskForm.addEventListener('submit', handleTaskSubmit);
    }
    
    // Add event delegation for edit and delete buttons
    document.addEventListener('click', function(e) {
        // Edit task button
        if (e.target.closest('.edit-task-btn')) {
            const taskId = e.target.closest('.edit-task-btn').dataset.taskId;
            editTask(taskId);
        }
        
        // Delete task button
        if (e.target.closest('.delete-task-btn')) {
            if (confirm('Are you sure you want to delete this task?')) {
                const taskId = e.target.closest('.delete-task-btn').dataset.taskId;
                deleteTask(taskId);
            }
        }
        
        // New task button
        if (e.target.closest('#new-task-btn')) {
            resetTaskForm();
            taskModalTitle.textContent = 'Add New Task';
            taskModal.show();
        }
    });
    
    /**
     * Handle task form submission
     */
    async function handleTaskSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(taskForm);
        const taskId = taskIdInput.value;
        const url = taskId ? `/tasks/${taskId}` : '/tasks';
        const method = taskId ? 'PUT' : 'POST';
        
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(Object.fromEntries(formData))
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Reload tasks or update UI as needed
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the task');
        }
    }
    
    /**
     * Edit task - load task data into modal
     */
    async function editTask(taskId) {
        try {
            const response = await fetch(`/tasks/${taskId}`);
            const task = await response.json();
            
            // Fill the form with task data
            taskIdInput.value = task.id;
            taskTitleInput.value = task.title;
            taskDescriptionInput.value = task.description || '';
            taskStatusInput.value = task.status;
            taskPriorityInput.value = task.priority;
            taskDueDateInput.value = task.due_date ? task.due_date.split(' ')[0] : '';
            
            // Update modal title and show
            taskModalTitle.textContent = 'Edit Task';
            taskModal.show();
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while loading the task');
        }
    }
    
    /**
     * Delete task
     */
    async function deleteTask(taskId) {
        try {
            const response = await fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Remove task from UI or reload
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to delete task'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the task');
        }
    }
    
    /**
     * Reset task form
     */
    function resetTaskForm() {
        taskIdInput.value = '';
        taskForm.reset();
        taskStatusInput.value = 'todo';
        taskPriorityInput.value = 'medium';
    }
    
    /**
     * Initialize drag and drop functionality
     */
    function initializeDragAndDrop() {
        // Make task cards draggable
        document.querySelectorAll('.task-card').forEach(taskCard => {
            taskCard.draggable = true;
            
            taskCard.addEventListener('dragstart', handleDragStart);
            taskCard.addEventListener('dragend', handleDragEnd);
        });
        
        // Set up drop zones
        Object.values(statusColumns).forEach(column => {
            column.addEventListener('dragover', handleDragOver);
            column.addEventListener('dragenter', handleDragEnter);
            column.addEventListener('dragleave', handleDragLeave);
            column.addEventListener('drop', handleDrop);
        });
    }
    
    // Drag and Drop Handlers
    function handleDragStart(e) {
        this.classList.add('dragging');
        e.dataTransfer.setData('text/plain', this.dataset.taskId);
        e.dataTransfer.effectAllowed = 'move';
    }
    
    function handleDragEnd() {
        this.classList.remove('dragging');
    }
    
    function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    }
    
    function handleDragEnter(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    }
    
    function handleDragLeave() {
        this.classList.remove('drag-over');
    }
    
    async function handleDrop(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        
        const taskId = e.dataTransfer.getData('text/plain');
        const taskCard = document.querySelector(`.task-card[data-task-id="${taskId}"]`);
        const newStatus = this.closest('.kanban-column').dataset.status;
        
        if (!taskCard || taskCard.dataset.status === newStatus) {
            return;
        }
        
        // Update task status in the database
        try {
            const response = await fetch(`/tasks/${taskId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: newStatus,
                    position: 0 // Will be updated on the server if needed
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update the task card in the UI
                taskCard.dataset.status = newStatus;
                const statusColumn = document.querySelector(`.kanban-column[data-status="${newStatus}"] .kanban-column-body`);
                statusColumn.insertBefore(taskCard, statusColumn.firstChild);
                
                // Update any status badges or styling
                const statusBadge = taskCard.querySelector('.task-status');
                if (statusBadge) {
                    statusBadge.className = `badge bg-${getStatusBadgeClass(newStatus)} task-status`;
                    statusBadge.textContent = formatStatus(newStatus);
                }
            } else {
                throw new Error(data.message || 'Failed to update task status');
            }
        } catch (error) {
            console.error('Error updating task status:', error);
            alert('An error occurred while updating the task status');
        }
    }
    
    /**
     * Helper function to format status for display
     */
    function formatStatus(status) {
        return status
            .split('_')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }
    
    /**
     * Helper function to get badge class based on status
     */
    function getStatusBadgeClass(status) {
        const statusClasses = {
            'todo': 'secondary',
            'in_progress': 'primary',
            'in_review': 'warning',
            'done': 'success'
        };
        return statusClasses[status] || 'secondary';
    }
});
