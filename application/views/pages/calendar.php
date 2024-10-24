<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <title>Document Management System</title>
    

  
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/main.min.css" rel="stylesheet">

</head>
<body>
    <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h3 class="text-center">Calendar</h3>
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#event_entry_modal"
                        onclick="showAddEventModal()">
                    Ajouter un événement
                </button>
            </div>
            <div class="bg-white p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Début de la boîte de dialogue contextuelle -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Ajouter un nouvel événement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="event_name">Nom de l'événement</label>
                                <input type="text" name="event_name" id="event_name" class="form-control"
                                       placeholder="Entrez le nom de votre événement">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="event_start_date">Début de l'événement (Date)</label>
                                <input type="date" name="event_start_date" id="event_start_date"
                                       class="form-control onlydatepicker" placeholder="Date de début de l'événement">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="event_start_time">Début de l'événement (Heure)</label>
                                <input type="time" name="event_start_time" id="event_start_time" class="form-control"
                                       placeholder="Heure de début de l'événement">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="event_end_date">Fin de l'événement (Date)</label>
                                <input type="date" name="event_end_date" id="event_end_date" class="form-control"
                                       placeholder="Date de fin de l'événement">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="event_end_time">Fin de l'événement (Heure)</label>
                                <input type="time" name="event_end_time" id="event_end_time" class="form-control"
                                       placeholder="Heure de fin de l'événement">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="delete_event_button" onclick="delete_event()"
                        style="display: none;">Supprimer l’événement
                </button>
                <button type="button" class="btn btn-primary" id="save_event_button" onclick="save_event()">Enregistrer
                    l’événement
                </button>
            </div>
        </div>
    </div>
</div>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
<script>
  var currentEvent = null;

  function showAddEventModal() {
    resetEventForm();
    $('#modalLabel').text('Ajouter un nouvel événement');
    $('#save_event_button').text('Enregistrer l’événement');
    $('#delete_event_button').hide(); // Hide the delete button for new event
  }

  function resetEventForm() {
    $('#event_name').val('');
    $('#event_start_date').val('');
    $('#event_start_time').val('');
    $('#event_end_date').val('');
    $('#event_end_time').val('');
    currentEvent = null;
  }

  function save_event() {
    var event_name = $('#event_name').val();
    var event_start_date = $('#event_start_date').val();
    var event_start_time = $('#event_start_time').val();
    var event_end_date = $('#event_end_date').val();
    var event_end_time = $('#event_end_time').val();
    console.log('Saving event:', event_name, event_start_date, event_start_time, event_end_date, event_end_time);

    if (event_name == '' || event_start_date == '' || event_start_time == '' || event_end_date == '' ||
        event_end_time == '') {
      alert('Veuillez entrer tous les détails requis.');
      return false;
    }

    var event_start_datetime = event_start_date + 'T' + event_start_time;
    var event_end_datetime = event_end_date + 'T' + event_end_time;

    var event_data = {
      event_name: event_name,
      event_start_datetime: event_start_datetime,
      event_end_datetime: event_end_datetime,
    };

    if (currentEvent) {
      $.ajax({
        url: "<?php echo base_url('calendar/update_event'); ?>",
        type: 'POST',
        dataType: 'json',
        data: {
          event_id: currentEvent.event_id,
          ...event_data,
        },
        success: function(response) {
          console.log('Update event response:', response);
          $('#event_entry_modal').modal('hide');
          if (response.status == true) {
            alert(response.msg);
            location.reload();
          } else {
            alert(response.msg);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error in update_event AJAX call:', xhr, status, error);
          alert('Erreur: ' + xhr.statusText);
        },
      });
    } else {
      $.ajax({
        url: "<?php echo base_url('calendar/save_event'); ?>",
        type: 'POST',
        dataType: 'json',
        data: event_data,
        success: function(response) {
          console.log('Save event response:', response);
          $('#event_entry_modal').modal('hide');
          if (response.status == true) {
            alert(response.msg);
            location.reload();
          } else {
            alert(response.msg);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error in save_event AJAX call:', xhr, status, error);
          alert('Erreur: ' + xhr.statusText);
        },
      });
    }

    return false;
  }

  function delete_event() {
    if (currentEvent) {
      if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
        $.ajax({
          url: "<?php echo base_url('calendar/delete_event'); ?>",
          type: 'POST',
          dataType: 'json',
          data: {
            event_id: currentEvent.event_id,
          },
          success: function(response) {
            console.log('Delete event response:', response);
            $('#event_entry_modal').modal('hide');
            if (response.status == true) {
              alert(response.msg);
              location.reload();
            } else {
              alert(response.msg);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error in delete_event AJAX call:', xhr, status, error);
            alert('Erreur: ' + xhr.statusText);
          },
        });
      }
    }
  }

  function display_events() {
    var events = [];

    $.ajax({
      url: '<?php echo base_url('calendar/display_event'); ?>',
      dataType: 'json',
      success: function(response) {
        var result = response.data;
        console.log('Display events response:', result);

        $.each(result, function(i, item) {
          events.push({
            event_id: item.event_id,
            title: item.title,
            start: item.start,
            end: item.end,
            color: item.color,
            url: item.url,
          });
        });

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          locale: 'fr',
          initialView: 'dayGridMonth',
          timeZone: 'local',
          editable: false,
          selectable: true,
          select: function(info) {
            console.log('Selected dates:', info.startStr, info.endStr);
            $('#event_start_date').val(info.startStr.split('T')[0]);
            $('#event_start_time').val(info.startStr.split('T')[1]?.substring(0, 5) || '');
            $('#event_end_date').val(info.endStr.split('T')[0]);
            $('#event_end_time').val(info.endStr.split('T')[1]?.substring(0, 5) || '');
            $('#modalLabel').text('Ajouter un nouvel événement');
            $('#save_event_button').text('Enregistrer l’événement');
            $('#event_entry_modal').modal('show');
            resetEventForm();
          },
          events: events,
          eventClick: function(info) {
            console.log(info.event.title);
            info.jsEvent.preventDefault();

            $('#event_name').val(info.event.title);
            $('#event_start_date').val(info.event.startStr.split('T')[0]);
            $('#event_start_time').val(info.event.startStr.split('T')[1]?.substring(0, 5) || '');
            $('#event_end_date').val(info.event.endStr.split('T')[0]);
            $('#event_end_time').val(info.event.endStr.split('T')[1]?.substring(0, 5) || '');
            $('#modalLabel').text('Modifier l’événement');
            $('#save_event_button').text('Mettre à jour l’événement');
            $('#delete_event_button').show(); // Show the delete button for existing event
            $('#event_entry_modal').modal('show');
            currentEvent = {
              event_id: info.event.extendedProps.event_id,
            };
          },
        });

        calendar.render();
      },
      error: function(xhr, status, error) {
        alert('Erreur: ' + xhr.statusText);
        console.error('Error in display_events AJAX call:', xhr, status, error);
      },
    });
  }

  $(document).ready(function() {
    console.log('Document ready, initializing display_events.');
    display_events();
  });
</script>
</body>
</html>