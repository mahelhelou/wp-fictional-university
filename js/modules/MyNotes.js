import $ from 'jquery'

class MyNotes {
  constructor() {
    // alert('testing MyNote class') // (TEST)
    this.events()
  }

  events() {
    // When You Click Anywhere in #my-notes
    $('#my-notes').on('click', '.delete-note', this.deleteNote)
    $('#my-notes').on('click', '.edit-note' ,this.editNote.bind(this))
    $('#my-notes').on('click', '.update-note' ,this.updateNote.bind(this))
    $('.submit-note').on('click', this.createNote.bind(this))
  }

  // Methods
  editNote(e) {
    let thisNote = $(e.target).parents('li') // data-id value
    if (thisNote.data('state') == 'editable') {
      this.makeNoteReadOnly(thisNote)
    } else {
      this.makeNoteEditable(thisNote)
    }
  }

  makeNoteEditable(thisNote) {
    thisNote.find('.edit-note').html('<i class="fa fa-times" aria-hidden="true"></i> Cancel')
    thisNote.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field')
    thisNote.find('.update-note').addClass('update-note--visible')
    thisNote.data('state', 'editable')
  }

  makeNoteReadOnly(thisNote) {
    thisNote.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit')
    thisNote.find('.note-title-field, .note-body-field').attr('readonly', 'readonly').removeClass('note-active-field')
    thisNote.find('.update-note').removeClass('update-note--visible')
    thisNote.data('state', 'cancel') // or readonly
  }

  deleteNote(e) {
    // alert('Want to delete note?') // (TEST)
    let thisNote = $(e.target).parents('li') // data-id value

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', fictionalUniversityData.nonce)
      },
      url: fictionalUniversityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'), // data-id value
      type: 'DELETE',
      success: (response) => {
        thisNote.slideUp() // delete without hard refresh
        console.log('Congrats')
        console.log(response)

        if (response.userNoteCount < 5) {
          $('.note-limit-message').removeClass('active')
        }
      },
      error: (response) => {
        console.log('Sorry')
        console.log(response)
      },
    })
  }

  updateNote(e) {
    let thisNote = $(e.target).parents('li') // data-id value
    // props must be exact to WP REST API
    let updatedPost = {
      'title': thisNote.find('.note-title-field').val(),
      'content': thisNote.find('.note-body-field').val()
    }

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', fictionalUniversityData.nonce)
      },
      url: fictionalUniversityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'), // data-id value
      type: 'POST',
      data: updatedPost,
      success: (response) => {
        this.makeNoteReadOnly(thisNote)
        console.log('Congrats')
        console.log(response)
      },
      error: (response) => {
        console.log('Sorry')
        console.log(response)
      },
    })
  }

  createNote(e) {
    let newdPost = {
      'title': $('.new-note-title').val(),
      'content': $('.new-note-body').val(),
      'status': 'publish' // def: 'draft'
    }

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', fictionalUniversityData.nonce)
      },
      url: fictionalUniversityData.root_url + '/wp-json/wp/v2/note/',
      type: 'POST',
      data: newdPost,
      success: (response) => {
        $('.new-note-title, .new-note-body').val('') // (UX)
        $(`
        <li data-id="${response.id}">
          <input readonly class="note-title-field" value="${response.title.raw}">
          <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
          <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
          <textarea readonly class="note-body-field">${response.content.raw}</textarea>
          <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
        </li>
        `).prependTo('#my-notes').hide().slideDown()
        console.log('Congrats')
        console.log(response)
      },
      error: (response) => {
        // Show error message when reaching notes limit
        if (response.responseText == "You have reached your notes limit!") {
          $('.note-limit-message').addClass('active') // (UX)
        }

        console.log('Sorry')
        console.log(response)
      },
    })
  }
}

export default MyNotes