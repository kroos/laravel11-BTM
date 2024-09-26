<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	@vite('resources/css/app.css')
	@livewireStyles
	<link href="{{ asset('assets/bootstrap.css') }}" rel="stylesheet">

</head>
<body class="container-fluid d-flex align-items-center justify-content-center">
	<div class="container row d-flex align-items-center justify-content-center border border-primary rounded">

		<div class="col-sm-8 border border-primary p-1 m-1" id="app">
		</div>

		<div class="col-sm-8 border border-primary p-1 m-1" id="applearnvue">
		</div>

		<div class="col-sm-8 border border-primary p-1 m-1">
			<table id="table" class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">First</th>
						<th scope="col">Last</th>
						<th scope="col">Handle</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope="row">1</th>
						<td>Mark</td>
						<td>Otto</td>
						<td>@mdo</td>
					</tr>
					<tr>
						<th scope="row">2</th>
						<td>Jacob</td>
						<td>Thornton</td>
						<td>@fat</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-8 row m-3 p-1 border border-danger justify-content-center">
			<select name="test" id="select2" class="form-select form-select-sm">
				<option value="">Please choose</option>
				<option value="1">1</option>
				<option value="2">2</option>
			</select>
		</div>
		<div class="col-sm-8 row d-flex justify-content-center m-1 p-1 border border-danger">
			<select id="Bname1" class="form-select form-select-sm col-sm-4 m-2">
				<option value="">Please Select</option>
				<option value="1" data-address="Address 1" data-suburb="Suburb 1" data-state="State 1">Option 1</option>
				<option value="2" data-address="Address 2" data-suburb="Suburb 2" data-state="State 2">Option 2</option>
				<option value="3" data-address="Address 3" data-suburb="Suburb 3" data-state="State 3">Option 3</option>
				<option value="4" data-address="Address 4" data-suburb="Suburb 4" data-state="State 4">Option 4</option>
				<option value="5" data-address="Address 5" data-suburb="Suburb 5" data-state="State 5">Option 5</option>
			</select>

			<div class="col-sm-12 row m-1 p-1 border">
				<label for="a1" class="col-form-label col-sm-2">Address : </label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="Badress" id="a1"/>
					</div>
				<label for="b1" class="col-form-label col-sm-2">Suburb : </label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="PCsuburb" id="b1"/>
					</div>
				<label for="c1" class="col-form-label col-sm-2">State : </label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="PCstate" id="c1"/>
					</div>
			</div>

		</div>
		<div class="col-sm-8 m-1 d-flex justify-content-center border border-info">
			<button class="btn btn-sm btn-block border border-secondary "><i class="fa-brands fa-firefox-browser fa-beat" style="color: #3763fb;"></i>&nbsp;FortAwesome Icon</button>
		</div>
		<div class="col-sm-8 d-flex justify-content-center m-1 border border-info">
			<span class="mdi mdi-loading mdi-spin"> Processing MDI Font</span>
			<br/>
			<span class="mdi mdi-account-arrow-up-outline"> MDI Font</span>
		</div>
		<div class="row col-sm-8 m-1 border border-info text-center">
			<h1 class="animate__animated animate__bounce">An animated element</h1>
		</div>
		<div class="row col-sm-8 m-1 border border-info text-center">
			<i class="bi-alarm" style="font-size: 2rem; color: cornflowerblue;">&nbsp;Bootstrap Icon</i>
		</div>
		<div class="row col-sm-8 m-1 border border-info justify-content-center">
			<select id="mark" name="mark" class="form-select form-select-sm col-sm-4" placeholder="Please choose">
				<option value="">--</option>
				<option value="1">BMW</option>
				<option value="2">Audi</option>
			</select>
			&nbsp;
			<select id="series" name="series" class="form-select form-select-sm col-sm-4" placeholder="Please choose">
				<option value="">--</option>
				<option value="series-3" class="1">3 series</option>
				<option value="series-5" class="1">5 series</option>
				<option value="series-6" class="1">6 series</option>
				<option value="a3" class="2">A3</option>
				<option value="a4" class="2">A4</option>
				<option value="a5" class="2">A5</option>
			</select>
		</div>
		<div class="col-sm-8 row d-flex justify-content-center m-1 border border-info">
			<label for="from" class="col-form-label col-sm-1">From : </label><input type="text" class="form-control form-control-sm col-sm-3 m-1 border" id="from">
			<label for="to" class="col-form-label col-sm-1">To : </label><input type="text" class="form-control form-control-sm col-sm-3 m-1 border" id="to">
		</div>
		<div class="col-sm-8 d-flex justify-content-center m-1 border border-info text-center">
			<div class="pretty p-icon p-round p-tada">
				<input type="checkbox" />
				<div class="state p-primary-o">
					<i class="icon mdi mdi-heart"></i>
					<label>Good</label>
				</div>
			</div>
		</div>
		<div class="col-sm-8 d-flex justify-content-center m-1 p-1 border border-info ">
			<button id="sweetalert" class="btn btn-sm btn-primary">Sweet Alert 2</button>
		</div>
		<div class="col-sm-auto col-8 m-3 p-3 border border-info ">
			<p class="muted">Placeholder text to demonstrate some <a href="#" data-bs-toggle="tooltip" data-bs-title="Default tooltip">inline links</a> with tooltips. This is now just filler, no killer. Content placed here just to mimic the presence of <a href="#" data-bs-toggle="tooltip" data-bs-title="Another tooltip">real text</a>. And all that just to give you an idea of how tooltips would look when used in real-world situations. So hopefully you've now seen how <a href="#" data-bs-toggle="tooltip" data-bs-title="Another one here too">these tooltips on links</a> can work in practice, once you use them on <a href="#" data-bs-toggle="tooltip" data-bs-title="The last tip!">your own</a> site or project.
			</p>
		</div>
		<div class="col-sm-12 col-8 m-1 border border-info ">
			<canvas id="myChart"></canvas>
		</div>
		<div class="col-sm-12 col-8 m-1 border border-info ">
			<div id='calendar'></div>
		</div>
		<div class="row col-sm-auto col-8 m-1 border border-info justify-content-center">
			<h3 class="m-1">ChatGPT</h3>
			<form class="row col-sm-8 m-1 p-1 border border-info" id="message">
				<div class="form-group row m-1 border border-info ">
					<label for="msg" class="col-sm-auto col-4 col-form-label m-1 p-1 border border-info align-items-center">Enter Message</label>
					<div class="col-sm-auto col-7 border border-info m-1 p-1">
						<input id="msg" type="text" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" value="{{ old('message') }}" placeholder="Enter message..." autocomplete="off" required autofocus>
						@if ($errors->has('message'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('message') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group row m-1 border border-info">
					<div class="col-sm-auto col-8 offset-sm-auto offset-4">
						<button type="submit" class="btn btn-primary btn-block">Submit</button>
					</div>
				</div>
				<div class="message">
					<div class="left message"></div>
				</div>
			</form>
		</div>
		<div class="col-sm-8 m-1 mb-5 border border-info ">
			<div id="accordion">
				<h3>Section 1</h3>
				<div>
					<p>
					Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
					ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
					amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
					odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
					</p>
				</div>
				<h3>Section 2</h3>
				<div>
					<p>
					Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
					purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
					velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
					suscipit faucibus urna.
					</p>
				</div>
				<h3>Section 3</h3>
				<div>
					<p>
					Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
					Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
					ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
					lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
					</p>
					<ul>
					<li>List item one</li>
					<li>List item two</li>
					<li>List item three</li>
					</ul>
				</div>
				<h3>Section 4</h3>
				<div>
					<p>
					Cras dictum. Pellentesque habitant morbi tristique senectus et netus
					et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
					faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
					mauris vel est.
					</p>
					<p>
					Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
					Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
					inceptos himenaeos.
					</p>
				</div>
				</div>
		</div>
				<div class="text-center text-sm text-black ">
						Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
				</div>
	</div>
</body>
<script type="text/javascript" src="{{ asset('assets/bootstrap/dist/js/bootstrap.bundle.js') }}"></script>
@vite('resources/js/app.js')
<script type="module" src="{{ asset('assets/jquery-chained/jquery.chained.js') }}"></script>
<script type="module" src="{{ asset('assets/jquery-chained/jquery.chained.remote.js') }}"></script>
<script type="module" src="{{ asset('assets/jquery-ui/dist/jquery-ui.js') }}"></script>
<script type="module" src="{{ asset('assets/bootstrapValidator/bootstrapValidator.js') }}"></script>
<script type="module" src="{{ asset('assets/datatable/dataTable-any-number.js') }}"></script>
<script type="module" src="{{ asset('assets/datatable/datetime-moment.js') }}"></script>

<script type="module">
	jQuery.noConflict ();
	(function($){
		$(document).ready(function(){
			@section('jquery')
			@show

			/////////////////////////////////////////////////////////////////////////////////////////
			// tooltip on reason
			$('[data-bs-toggle="tooltip"]').tooltip();

			// alert("Hello\nHow are you?");
			$('#table').DataTable();

			$('#select2').select2({
				theme: 'bootstrap-5',
			});

			$("#series").chainedTo("#mark");

			$("#accordion").accordion();

			$('#Bname1').change(function() {
				var selectedOption = $('option:selected', this);
				$('#a1').val( selectedOption.data('address') );
				$('#b1').val( selectedOption.data('suburb') );
				$('#c1').val( selectedOption.data('state') );
			});

			moment().format();
			console.log(moment.duration(2, 'days'));

			// pc-bootstrap4-datetimepicker
			// $('#datepicker').datetimepicker();

			// jquery-ui
			var array = [moment().format('YYYY-MM-DD')];
			// console.log(array);
			$('#from').datepicker({
				dateFormat: 'yy-mm-dd',
				// disable date
				// beforeShowDay: function(date){
				// 	var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
				// 	return [ array.indexOf(string) == -1 ]
				// }
			}).on('change', function() {
				// console.log(this.value);
				$('#to').datepicker('option', 'minDate', this.value);
			});

			$('#to').datepicker({
				dateFormat: 'yy-mm-dd',
				// disable date
				// beforeShowDay: function(date){
				// 	var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
				// 	return [ array.indexOf(string) == 0 ]
				// }
			}).on('change', function() {
				// console.log(this.value);
				$('#from').datepicker('option', 'maxDate', this.value);
			});

			$('#sweetalert').click(function(){
				swal.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						swal.fire(
									'Deleted!',
									'Your file has been deleted.',
									'success'
									)
					}
				});
			});

			// chatgpt
			$("form").submit(function (event) {
				event.preventDefault();

				//Stop empty messages
				if ($("form #msg").val().trim() === '') {
					return;
				}

				//Disable form
				$("form #msg").prop('disabled', true);
				$("form button").prop('disabled', true);

				$.ajax({
					url: "/chat",
					method: 'POST',
					headers: {
						'X-CSRF-TOKEN': "{{csrf_token()}}"
					},
					data: {
						"model": "gpt-3.5-turbo",
						"content": $("form #msg").val()
					}
				}).done(function (res) {

					//Populate sending message
					$(".messages > .message").last().after('<div class="right message">' +
															'<p>' + $("form #message").val() + '</p>' +
															'</div>');

					//Populate receiving message
					$(".messages > .message").last().after('<div class="left message">' +
															'<p>' + res + '</p>' +
															'</div>');

					//Cleanup
					$("form #message").val('');
					$(document).scrollTop($(document).height());

					//Enable form
					$("form #message").prop('disabled', false);
					$("form button").prop('disabled', false);
				});
			});

			//////////////////////////////////////////////////////////////////////////////////////////////
			// fullcalendar
			const calendarEl = document.getElementById('calendar')
			// const calendar = new FullCalendar.Calendar(calendarEl, {
			const calendar = new Calendar(calendarEl, {
				plugins: [
					timeGridPlugin,
					dayGridPlugin,
					multiMonthPlugin,
					momentPlugin,
					bootstrap5Plugin
				],
				aspectRatio: 1.0,
				height: 2000,
				weekNumbers: true,
				themeSystem: 'bootstrap',
				initialView: 'multiMonthYear',
				// initialView: 'dayGridMonth',
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					// right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
					right: 'multiMonthYear,dayGridMonth,timeGridWeek'
				},
				// events: {
				// 	url: '{{ url('/') }}',
				// 	method: 'GET',
				// 	extraParams: {
				// 		_token: '{!! csrf_token() !!}',
				// 	},
				// },
				// failure: function() {
				// 	alert('There was an error while fetching leaves!');
				// },
				events: [
							{
								title: 'Test Calendar',
								start: '{{ now() }}',
								end: '{{ now() }}',
								// url: route('hrleave.show', $v->id),
								allDay: true,
								// extendedProps: {
								// 						department: 'BioChemistry'
								// 					},
								description: 'Test Tooltips',
								color: 'teal',
								textColor: 'yellow',
								borderColor: 'green',
							}
				],
				eventDidMount: function(info) {
					$(info.el).tooltip({
						title: info.event.extendedProps.description,
						placement: 'top',
						trigger: 'hover',
						container: 'body'
					});
				},
				eventTimeFormat: { // like '14:30:00'
					hour: '2-digit',
					minute: '2-digit',
					second: '2-digit',
					hour12: true
				}
			})
			calendar.render()

			//////////////////////////////////////////////////////////////////////////////////////////////
			// chartjs
			const ctx = document.getElementById('myChart');
			new Chart(ctx, {
				type: 'line',
				data: {
					labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
					datasets: [
						{
							label: '# of Votes',
							data: [12, 19, 3, 5, 2, 3],
							borderWidth: 1
						},
						{
							label: '# of Votes',
							data: [12, 19, 3, 5, 2, 3],
							data: [3, 2, 5, 3, 19, 12],
							borderWidth: 1
						},
					]
				},
				options: {
					responsive: true,
					scales: {
						y: {
							beginAtZero: true
						}
					},
					interaction: {
						intersect: false,
						mode: 'index',
					},
				},
				plugins: {
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Votes Of The Day'
					},
				},
			});

			/////////////////////////////////////////////////////////////////////////////////////////
		});
	})(jQuery);
</script>
@livewireScripts
</html>
