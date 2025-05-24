/**
 * Notes Management Script
 * Handles all note-related frontend functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const noteForm = document.getElementById('note-form');
    const noteModal = new bootstrap.Modal(document.getElementById('noteModal'));
    const noteModalTitle = document.getElementById('noteModalLabel');
    const noteIdInput = document.getElementById('note-id');
    const noteTitleInput = document.getElementById('note-title');
    const noteContentInput = document.getElementById('note-content');
    const noteTagInput = document.getElementById('note-tag');
    const notesContainer = document.querySelector('.notes-container');
    
    // Initialize tag selector if using a tag selector library
    initializeTagSelector();
    
    // Event Listeners
    if (noteForm) {
        noteForm.addEventListener('submit', handleNoteSubmit);
    }
    
    // Add event delegation for edit and delete buttons
    document.addEventListener('click', function(e) {
        // Edit note button
        if (e.target.closest('.edit-note-btn')) {
            const noteId = e.target.closest('.edit-note-btn').dataset.noteId;
            editNote(noteId);
        }
        
        // Delete note button
        if (e.target.closest('.delete-note-btn')) {
            if (confirm('Are you sure you want to delete this note? This action cannot be undone.')) {
                const noteId = e.target.closest('.delete-note-btn').dataset.noteId;
                deleteNote(noteId);
            }
        }
        
        // New note button
        if (e.target.closest('#new-note-btn')) {
            resetNoteForm();
            noteModalTitle.textContent = 'Add New Note';
            noteModal.show();
        }
        
        // View note
        if (e.target.closest('.note-card')) {
            const noteId = e.target.closest('.note-card').dataset.noteId;
            viewNote(noteId);
        }
    });
    
    // Search functionality
    const searchInput = document.querySelector('.note-search');
    if (searchInput) {
        searchInput.addEventListener('input', filterNotes);
    }
    
    // Tag filter
    const tagFilter = document.getElementById('tag-filter');
    if (tagFilter) {
        tagFilter.addEventListener('change', filterNotes);
    }
    
    /**
     * Handle note form submission
     */
    async function handleNoteSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(noteForm);
        const noteId = noteIdInput.value;
        const url = noteId ? `/notes/${noteId}` : '/notes';
        const method = noteId ? 'PUT' : 'POST';
        
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
                // Close modal and refresh notes
                noteModal.hide();
                loadNotes();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the note');
        }
    }
    
    /**
     * Load all notes
     */
    async function loadNotes() {
        try {
            const response = await fetch('/tasks'); // This should return the tasks view with notes
            const html = await response.text();
            
            // Parse the HTML and extract the notes section
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const notesSection = doc.querySelector('.notes-section');
            
            if (notesSection) {
                // Update the notes container with the new content
                document.querySelector('.notes-section').innerHTML = notesSection.innerHTML;
                
                // Reinitialize any event listeners or plugins
                initializeTagSelector();
            }
        } catch (error) {
            console.error('Error loading notes:', error);
            alert('An error occurred while loading notes');
        }
    }
    
    /**
     * View note details
     */
    async function viewNote(noteId) {
        try {
            const response = await fetch(`/notes/${noteId}`);
            const note = await response.json();
            
            // Fill the form with note data
            noteIdInput.value = note.id;
            noteTitleInput.value = note.title;
            noteContentInput.value = note.content || '';
            noteTagInput.value = note.tag || '';
            
            // Update tag selector if using a library
            updateTagSelector(note.tag);
            
            // Update modal title and show
            noteModalTitle.textContent = 'View/Edit Note';
            noteModal.show();
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while loading the note');
        }
    }
    
    /**
     * Edit note - alias for viewNote since they use the same modal
     */
    async function editNote(noteId) {
        await viewNote(noteId);
    }
    
    /**
     * Delete note
     */
    async function deleteNote(noteId) {
        try {
            const response = await fetch(`/notes/${noteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Remove note from UI or refresh
                loadNotes();
            } else {
                throw new Error(data.message || 'Failed to delete note');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the note');
        }
    }
    
    /**
     * Reset note form
     */
    function resetNoteForm() {
        noteIdInput.value = '';
        noteForm.reset();
        noteTagInput.value = '';
        
        // Reset tag selector if using a library
        if (window.tagify) {
            window.tagify.removeAllTags();
        }
    }
    
    /**
     * Filter notes based on search input and selected tag
     */
    function filterNotes() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const selectedTag = tagFilter ? tagFilter.value : '';
        
        document.querySelectorAll('.note-card').forEach(noteCard => {
            const title = noteCard.querySelector('.note-title').textContent.toLowerCase();
            const content = noteCard.querySelector('.note-content').textContent.toLowerCase();
            const tags = noteCard.dataset.tags ? noteCard.dataset.tags.toLowerCase().split(',') : [];
            
            const matchesSearch = !searchTerm || 
                                title.includes(searchTerm) || 
                                content.includes(searchTerm);
                                
            const matchesTag = !selectedTag || 
                             (tags.length && tags.some(tag => tag.trim() === selectedTag));
            
            if (matchesSearch && matchesTag) {
                noteCard.style.display = '';
            } else {
                noteCard.style.display = 'none';
            }
        });
    }
    
    /**
     * Initialize tag selector (using Tagify or similar library)
     */
    function initializeTagSelector() {
        // Example using Tagify (you'll need to include the library)
        if (typeof Tagify === 'function' && noteTagInput) {
            window.tagify = new Tagify(noteTagInput, {
                whitelist: ['work', 'personal', 'important', 'ideas', 'todo'],
                maxTags: 5,
                dropdown: {
                    maxItems: 20,
                    classname: 'tagify-dropdown',
                    enabled: 1,
                    closeOnSelect: false
                },
                enforceWhitelist: false // Allow custom tags
            });
        }
    }
    
    /**
     * Update tag selector with existing tags
     */
    function updateTagSelector(tags) {
        if (window.tagify && tags) {
            window.tagify.removeAllTags();
            window.tagify.addTags(tags.split(',').map(tag => tag.trim()));
        }
    }
    
    // Load initial notes
    loadNotes();
});
