<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Notes</h2>
        <div class="mb-4">
            <button type="button" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors"
                    id="addNoteButton">
                <i class="fas fa-plus"></i>
                <span>Add Note</span>
            </button>
        </div>
    </div>

    <div class="py-4">
        <!-- Compact Notes List -->
        <div class="space-y-4 mb-6" id="compact-notes">
            <?php $__empty_1 = true; $__currentLoopData = $notes->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow transition-shadow">
                    <div class="flex justify-between items-start">
                        <h3 class="font-medium text-gray-800 truncate pr-2"><?php echo e($note->title); ?></h3>
                        <?php if($note->tag): ?>
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-0.5 rounded-full whitespace-nowrap">
                                <?php echo e($note->tag); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="text-gray-600 text-sm mt-1 line-clamp-2">
                        <?php echo nl2br(e($note->content)); ?>

                    </div>
                    <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                        <span><?php echo e($note->created_at->diffForHumans()); ?></span>
                        <?php if($note->updated_at->ne($note->created_at)): ?>
                            <span class="text-gray-400">edited</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                    <div class="text-gray-400 mb-2">
                        <i class="fas fa-sticky-note text-4xl"></i>
                    </div>
                    <p class="text-gray-500">No notes found. Create your first note by clicking the button above.</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if($notes->count() > 5): ?>
            <div class="text-center">
                <button id="viewAllNotes" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center justify-center">
                    View all <?php echo e($notes->count()); ?> notes
                    <svg class="w-4 h-4 ml-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        <?php endif; ?>

        <!-- Full-screen Notes Modal -->
        <div id="allNotesModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-white">
            <div class="min-h-screen p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">All Notes</h2>
                    <button id="closeAllNotes" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="h-[calc(100vh-120px)] overflow-y-auto">
                    <div class="grid grid-rows-2 grid-flow-col auto-cols-[minmax(300px,400px)] gap-6 pb-6">
                        <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow h-fit">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="font-medium text-gray-800 text-lg"><?php echo e($note->title); ?></h3>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600 p-1 -mr-2">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-1 w-32 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200" style="display: none;">
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 edit-note" data-note-id="<?php echo e($note->id); ?>">
                                                <i class="fas fa-edit mr-2"></i>Edit
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 delete-note" data-note-id="<?php echo e($note->id); ?>">
                                                <i class="fas fa-trash-alt mr-2"></i>Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if($note->tag): ?>
                                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-0.5 rounded-full mb-3">
                                        <?php echo e($note->tag); ?>

                                    </span>
                                <?php endif; ?>
                                
                                <div class="text-gray-600 mb-4">
                                    <?php echo nl2br(e($note->content)); ?>

                                </div>
                                
                                <div class="pt-3 border-t border-gray-100 text-sm text-gray-500">
                                    <div>Created <?php echo e($note->created_at->diffForHumans()); ?></div>
                                    <?php if($note->updated_at->ne($note->created_at)): ?>
                                        <div class="text-xs text-gray-400">Last edited <?php echo e($note->updated_at->diffForHumans()); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Note Modal -->
<div id="createNoteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <!-- Backdrop with smooth transition -->
        <div class="fixed inset-0 bg-black/90 backdrop-blur-sm transition-opacity" id="modalBackdrop"></div>
        
        <!-- Modal Container with smooth animation -->
        <div class="relative w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all">
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-gray-100 p-6 pb-4">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">Add New Note</h3>
                    <p class="mt-1 text-sm text-gray-500">Add a new note to keep track of important information</p>
                </div>
                <button type="button" id="closeModalBtn" class="rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form id="noteForm" class="p-6">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="note_id" name="note_id">
                
                <div class="space-y-6">
                    <!-- Title Field -->
                    <div>
                        <label for="note_title" class="mb-2 block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                        <input type="text" 
                               class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 focus:ring-opacity-50" 
                               id="note_title" 
                               name="title" 
                               placeholder="Enter note title"
                               required>
                    </div>
                    
                    <!-- Tag Field -->
                    <div>
                        <label for="note_tag" class="mb-2 block text-sm font-medium text-gray-700">Tags</label>
                        <div class="relative">
                            <input type="text" 
                                   class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 focus:ring-opacity-50" 
                                   id="note_tag" 
                                   name="tag"
                                   placeholder="e.g. important, todo, reference">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <span class="text-xs text-gray-400">Optional</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Field -->
                    <div>
                        <label for="note_content" class="mb-2 block text-sm font-medium text-gray-700">Content <span class="text-red-500">*</span></label>
                        <textarea class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 focus:ring-opacity-50" 
                                  id="note_content" 
                                  name="content" 
                                  rows="6" 
                                  placeholder="Write your note here..."
                                  required></textarea>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="mt-8 flex items-center justify-end space-x-3 border-t border-gray-100 px-6 py-4">
                    <button type="button" 
                            class="rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            id="cancelNote">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="rounded-lg bg-indigo-600 px-6 py-3 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 hover:shadow-md transform hover:-translate-y-0.5">
                        <span class="flex items-center">
                            <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Save Note
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    @media (min-width: 768px) {
        #notes-container {
            column-count: 2;
        }
    }
    
    @media (min-width: 1024px) {
        #notes-container {
            column-count: 3;
        }
    }
    
    .break-inside-avoid {
        break-inside: avoid;
        -webkit-column-break-inside: avoid;
        page-break-inside: avoid;
    }
    
    .line-clamp-4 {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    #allNotesModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 50;
        background-color: white;
    }
    
    #allNotesModal.show {
        display: block;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal elements
        const modal = document.getElementById('createNoteModal');
        const modalBackdrop = document.getElementById('modalBackdrop');
        const closeButton = document.getElementById('closeModalBtn');
        const cancelButton = document.getElementById('cancelNote');
        const addNoteButton = document.getElementById('addNoteButton');
        const noteForm = document.getElementById('noteForm');
        
        // Check if modal elements exist
        if (!modal) {
            console.error('Modal element not found');
            return;
        }

        // Close modal function with better event handling
        function hideModal() {
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                
                // Only try to handle closeButton if it exists
                if (closeButton && closeButton.parentNode) {
                    const newCloseBtn = closeButton.cloneNode(true);
                    closeButton.parentNode.replaceChild(newCloseBtn, closeButton);
                }
            }
        }

        // Show modal function with better focus management
        function showModal() {
            if (!modal) return;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Focus the first input when modal opens
            setTimeout(() => {
                if (modal) {
                    const firstInput = modal.querySelector('input, textarea, button');
                    if (firstInput) firstInput.focus();
                }
            }, 100);
            
            // Re-attach close button event listener
            const closeBtn = document.getElementById('closeModalBtn');
            if (closeBtn) {
                closeBtn.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    hideModal();
                };
            }
        }
        
        // Show modal when Add Note button is clicked
        if (addNoteButton) {
            addNoteButton.addEventListener('click', function(e) {
                e.preventDefault();
                noteForm.reset();
                document.getElementById('note_id').value = '';
                document.getElementById('modalTitle').textContent = 'Add New Note';
                showModal();
            });
        }
        
        // Close modal when clicking cancel button
        if (cancelButton) {
            cancelButton.addEventListener('click', hideModal);
        }
        
        // Close modal when clicking outside
        if (modalBackdrop) {
            modalBackdrop.addEventListener('click', hideModal);
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                hideModal();
            }
        });
        
        // Prevent clicks inside modal from closing it
        modal.querySelector('.relative').addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Handle edit note
        document.querySelectorAll('.edit-note').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const noteId = this.getAttribute('data-note-id');
                fetch(`/notes/${noteId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('note_id').value = data.id;
                        document.getElementById('note_title').value = data.title;
                        document.getElementById('note_tag').value = data.tag || '';
                        document.getElementById('note_content').value = data.content;
                        document.getElementById('modalTitle').textContent = 'Edit Note';
                        showModal();
                    });
            });
        });
        
        // Handle form submission
        if (noteForm) {
            noteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const noteId = formData.get('note_id');
                const url = noteId ? `/notes/${noteId}` : '/notes';
                const method = noteId ? 'PUT' : 'POST';
                
                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    hideModal();
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        }
        
        // Handle delete note
        document.querySelectorAll('.delete-note').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this note?')) {
                    const noteId = this.getAttribute('data-note-id');
                    
                    fetch(`/notes/${noteId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        });
        
        // Toggle all notes modal
        const viewAllBtn = document.getElementById('viewAllNotes');
        const allNotesModal = document.getElementById('allNotesModal');
        const closeAllNotes = document.getElementById('closeAllNotes');
        
        if (viewAllBtn) {
            viewAllBtn.addEventListener('click', function() {
                allNotesModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            });
        }
        
        if (closeAllNotes) {
            closeAllNotes.addEventListener('click', function() {
                allNotesModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && allNotesModal.classList.contains('show')) {
                allNotesModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\eduflow\resources\views/tasks/partials/notes.blade.php ENDPATH**/ ?>