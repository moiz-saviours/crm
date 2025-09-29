<!-- Edit Note Modal -->
<div class="modal fade NoteModal" id="editNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="editNoteModalForm">
                @csrf
                <div class="modal-body">
                    <textarea id="note" name="note" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Note</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('script')
    <script>

        /** Use ::::::::: AjaxRequestPromise :::::::::::::: */
        /** Edit Note */
        $(document).on('click', '.editNoteModal', function () {
            const id = $(this).data('id');
            const noteText = $(this).data('note'); // Get note from data attribute

            if (!id) {
                Swal.fire('Error!', 'Record not found.', 'error');
                return;
            }
            // Reset form
            $('#editNoteModalForm')[0].reset();

            // Update form action URL
            $('#editNoteModalForm').attr('action', `{{route('admin.customer.contact.note.update')}}/` + id);

            $('#note').val(noteText);
        });


    </script>
@endpush
