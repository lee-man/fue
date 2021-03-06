<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FUE Client List</title>
    <link href="<?php echo base_url('assests/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assests/bootstrap/css/starter-template.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel='stylesheet' href='<?php echo base_url(); ?>application/libraries/fullcalendar/fullcalendar.css' />
    <script src='<?php echo base_url(); ?>application/libraries/lib/moment.min.js'></script>
    <script src='<?php echo base_url(); ?>application/libraries/lib/jquery.min.js'></script>
    <link href='<?php echo base_url(); ?>application/libraries/lib/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <script src='<?php echo base_url(); ?>application/libraries/fullcalendar/fullcalendar.js'></script>
    <!--<script src="<?php echo base_url('assests/jquery/jquery-3.1.0.min.js')?>"></script>-->
    <script src="<?php echo base_url('assests/bootstrap/js/bootstrap.min.js')?>"></script>

  </head>

  <body>
    <?php $this->load->view('layouts/_header.html');  ?>

  <div class="container">
    <h1>FUE Calendar</h1>

    <div id='calendar'></div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add Calendar Event</h4>
          </div>
          <div class="modal-body">
            <?php echo form_open(site_url("index.php/calendar/add_event"), array("class" => "form-horizontal")) ?>
          <div class="form-group">
                    <label for="p-in" class="col-md-4 label-heading">Event Title</label>
                    <div class="col-md-8 ui-front">
                        <input type="text" class="form-control" value="-- Your name here --" name="title" id="title">
                    </div>
            </div>
            
            <div class="form-group">
                    <label for="p-in" class="col-md-4 label-heading">Start Date</label>
                    <div class="col-md-8">
                        <input type="text"  class="form-control" name="start_date" id="start_date">
                    </div>
            </div>
            <div class="form-group">
                    <label for="p-in" class="col-md-4 label-heading">End Date</label>
                    <div class="col-md-8">
                        <input type="text"  class="form-control" name="end_date" id="end_date">
                    </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Add Event">
            <?php echo form_close() ?>
          </div>
          </div>
            </div>
      </div>
      
          <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Update - Delete Calendar Event</h4>
          </div>
          <div class="modal-body">
          <?php echo form_open(site_url("index.php/calendar/edit_event"), array("class" => "form-horizontal")) ?>
              <div class="form-group">
                        <label for="p-in" class="col-md-4 label-heading">Event Title</label>
                        <div class="col-md-8 ui-front">
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                </div>
                
                <div class="form-group">
                        <label for="p-in" class="col-md-4 label-heading">Start Date</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control"  name="start_date" id="start_date">
                        </div>
                </div>
                <div class="form-group">
                        <label for="p-in" class="col-md-4 label-heading">End Date</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control"  name="end_date" id="end_date">
                        </div>
                </div>
                
                <div class="form-group">
                            <label for="p-in" class="col-md-4 label-heading"><i>Delete Event?</i></label>
                            <div class="col-md-8">
                                <input type="checkbox" name="delete" value="1">
                            </div>
                    </div>
                    <input type="hidden" name="eventid" id="eventid"  />
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Edit Event">
                  <?php echo form_close() ?>
                </div>
              </div>
            </div>
      </div>

  </div>
  <script type="text/javascript">
  $(document).ready(function() {
      var d = new Date()
      currentDate = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
      //$.datepicker.formatDate('yy/mm/dd', new Date());
      //var date_last_clicked = null;
      
      $('#calendar').fullCalendar({

          events:
                {
                      url: '<?php echo base_url() ?>index.php/calendar/get_events',
                      dataType: 'json',
                      data: {
                        start: '2017-09-01',
                        end: '2017-12-31'
                      },

                      success: function(response) {
                        //console.log(JSON.stringify(response));
                        return response.events;

                      },

                      error: function(jqXHR, textStatus, errorThrown) {
                          //console.log(response);
                        console.log(errorThrown);
                      }

              }

            ,

          dayClick: function(date, jsEvent, view) {
              date_last_clicked = $(this);
              formDate =moment(date).format('YYYY-MM-DD');
              //alert(" Start Date: " + formDate);
              $(this).css('background-color', '#bed7f3');
              $('#addModal #start_date').val(formDate);
              $('#addModal #end_date').val(formDate);
              $('#addModal').modal();
              //  .data(myDate,formDate);
              
          },
         eventClick: function(event, jsEvent, view) {
            console.log(JSON.stringify(event));
            $('#editModal #title').val(event.title);
            //$('#description').val(event.description);
            $('#editModal #start_date').val(moment(event.start).format('YYYY-MM-DD'));
            if(event.end) {
              $('#editModal #end_date').val(moment(event.end).format('YYYY-MM-DD'));
            } else {
              $('#editModal #end_date').val(moment(event.start).format('YYYY-MM-DD'));
            }
            $('#editModal #eventid').val(event.eventid);
            $('#editModal').modal();
         },

          editable: true,
          eventDrop: function(event, delta, revertFunc) {

              alert(event.title + " was dropped on " + event.start.format());

              if (!confirm("Are you sure about this change?")) {
                  revertFunc();
              }

          }
      });
  });
  </script>


  </body>
</html>
