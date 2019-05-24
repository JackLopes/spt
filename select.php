
<!doctype html>
<html class="demo">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>select2-bootstrap-theme</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/cdnjs.css">
        <link rel="stylesheet" href="css/Style2.css">
        <link rel="stylesheet" href="css/gh.css">
	<!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="js/respond.min.js"></script>
	<![endif]-->
</head>

	<body>
		<header class="navbar navbar-default" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".bs-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.html">select2-bootstrap-theme</a>
		</div>

		<div class="collapse navbar-collapse bs-navbar-collapse">
			<ul class="nav navbar-nav">
				
					<li class="">
						<a href="4.0.0.html">4.0.0</a>
					</li>
				
					<li class="">
						<a href="4.0.1.html">4.0.1</a>
					</li>
				
					<li class="">
						<a href="4.0.2.html">4.0.2</a>
					</li>
				
					<li class="active">
						<a href="4.0.3.html">4.0.3</a>
					</li>
				
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="https://github.com/select2/select2-bootstrap-theme">
						<i class="fa fa-github"></i>
						GitHub
					</a>
				</li>
			</ul>
		</div>
	</div>
</header>


		<div class="container">

			<div class="form-group">
				<label for="default" class="control-label">Default textbox</label>
				<input id="default" type="text" class="form-control" placeholder="Placeholder text">
			</div>

			<div class="form-group">
				<label for="single" class="control-label">Select2 single select</label>
				<select id="single" class="form-control select2-single">
					<option></option>
					<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

				</select>
			</div>

			<div class="form-group">
				<label for="multiple" class="control-label">Select2 multi select</label>
				<select id="multiple" class="form-control select2-multiple" multiple>
					<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

				</select>
			</div>

			<div class="page-header">
				<h1 id="input-groups">Input Groups</h1>
			</div>

			<div class="form-group">
				<label for="select2-single-append" class="control-label">Select2 append Checkbox</label>
				<div class="input-group">
					<span class="input-group-addon">
						<input type="checkbox" checked>
					</span>
					<select id="select2-single-append" class="form-control select2-allow-clear">
						<option></option>
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="single-append-radio" class="control-label">Select2 multi append Radiobutton</label>
				<div class="input-group">
					<span class="input-group-addon">
						<input type="radio">
					</span>
					<select id="single-append-radio" class="form-control select2-allow-clear" multiple>
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="single-append-text" class="control-label">Select2 append</label>
				<div class="input-group">
					<select id="single-append-text" class="form-control select2-allow-clear">
						<option></option>
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-select2-open="single-append-text">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
				</div>
			</div>

			<div class="form-group">
				<label for="single-prepend-text" class="control-label">Select2 prepend</label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
					<select id="single-prepend-text" class="form-control select2-single">
						<option></option>
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="multi-append" class="control-label">Select2 multi append</label>
				<div class="input-group">
					<select id="multi-append" class="form-control select2-multiple" multiple>
						<option></option>
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
					</select>
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-select2-open="multi-append">
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</span>
				</div>
			</div>

			<div class="form-group">
				<label for="multi-prepend" class="control-label">Select2 multi prepend</label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-select2-open="multi-prepend">
							State
						</button>
					</span>
					<select id="multi-prepend" class="form-control select2-multiple" multiple>
						<option></option>
							<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="multi-prepend-append" class="control-label">Select2 multi append + prepend</label>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" data-select2-open="multi-prepend-append">
							State
						</button>
					</span>
					<select id="multi-prepend-append" class="form-control select2-multiple" multiple>
						<option></option>
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
					<span class="input-group-addon">… is my favorite!</span>
				</div>
			</div>

			<div class="page-header">
				<h1 id="rtl-support-and-control-sizing">
					RTL Support and Bootstrap Control Sizing
				</h1>
			</div>

			<p>The theme offers styles to display "small" and "large" Select2 widgets in <a href="http://getbootstrap.com/components/#input-groups">Bootstrap Input Groups</a> with <a href="http://getbootstrap.com/css/#forms-control-sizes">Bootstrap Control Sizing</a> classes applied (e. g. Select2 in <code>.input-group.input-group-sm</code> or <code>.input-group.input-group-lg</code>). You may also apply the <a href="http://getbootstrap.com/css/#forms-control-sizes">Bootstrap Control Sizing</a> classes directly to the <code>.select2-container</code> to alter its appearance.</p>

			<div class="alert alert-info" role="alert">
				<h4>Requires select2.full.js</h4>
				<p>Those of you familiar with Select2 v3 remember that the default behavior was to copy the original elements CSS-classes to the container of the Select2 element. Select2 v4 provides a similar functionality in its full build, <a href="https://github.com/select2/select2/blob/master/dist/js/select2.full.js">select2.full.js</a>. It contains a compatibility module which behaves similar to v3 in copying CSS classes from the original <code>&lt;select&gt;</code> element. To invoke, set the <code>containerCssClass</code> option to <code>:all:</code>.</p>
			</div>

			<div class="row">
				<div class="col-md-4">
					<label for="select2-multiple-input-sm" class="control-label">col-md-4</label>
					<select id="select2-multiple-input-sm" class="form-control input-sm select2-multiple" multiple dir="rtl">
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
					<p class="help-block"><a href="https://select2.github.io/examples.html#rtl">RTL support</a> via <code>dir="rtl"</code></p>
				</div>
				<div class="col-md-3">
					<label for="select2-single-input-sm" class="control-label">col-md-3</label>
					<select id="select2-single-input-sm" class="form-control input-sm select2-single">
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
				</div>
				<div class="col-md-2">
					<label for="bootstrap-input-sm" class="control-label">Bootstrap input</label>
					<input id="bootstrap-input-sm" class="form-control input-sm" placeholder=".input-sm">
				</div>
				<div class="col-md-3">
					<div class="form-group has-success">
						<label for="select2-single-input-group-sm" class="control-label">col-md-3</label>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">
								<input type="radio">
							</span>
							<select id="select2-single-input-group-sm" class="form-control select2-single">
								<option></option>
								<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

							</select>
						</div>
					</div>
				</div>
			</div>



			<div class="row">
				<div class="col-md-4 has-warning">
					<label for="select2-multiple" class="control-label">col-md-4</label>
					<select id="select2-multiple" class="form-control select2-multiple" multiple>
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
					<p class="help-block">Example <a href="http://getbootstrap.com/css/#forms-help-text">block-level help text</a>.</p>
				</div>
				<div class="col-md-3">
					<label for="span_small" class="control-label">col-md-3</label>
					<select id="span_small" class="form-control select2-single">
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
				</div>
				<div class="col-md-2">
					<label for="span-medium">Bootstrap input</label>
					<input id="span-medium" class="form-control" placeholder=".col-md-2">
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="span_large" class="control-label">col-md-3</label>
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" checked>
							</span>
							<select id="span_large" class="form-control select2-single">
								<option></option>
								<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

							</select>
						</div>
					</div>
				</div>
			</div>



			<div class="row">
				<div class="col-md-4">
					<label for="select2-multiple-input-lg" class="control-label">col-md-4</label>
					<select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" multiple>
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
				</div>
				<div class="col-md-3">
					<label for="select2-single-input-lg" class="control-label">col-md-3</label>
					<select id="select2-single-input-lg" class="form-control input-lg select2-multiple" dir="rtl">
						<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

					</select>
				</div>
				<div class="col-md-2">
					<label for="bootstrap-input-lg" class="control-label">Bootstrap input</label>
					<input id="bootstrap-input-lg" class="form-control input-lg" placeholder=".input-lg">
				</div>
				<div class="col-md-3">
					<div class="form-group has-error">
						<label for="select2-multiple-input-group-lg" class="control-label">col-md-3</label>
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
								<input type="radio">
							</span>
							<select id="select2-multiple-input-group-lg" class="form-control select2-single">
								<option></option>
								<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

							</select>
						</div>
					</div>
				</div>
			</div>

			<h2 id="horizontal-form-group-sizes">
				Horizontal form group sizes
			</h2>

			<p>The theme's styles work in <a href="http://getbootstrap.com/css/?#forms-horizontal">Bootstrap's Horizontal Forms</a> and offers support for <a href="http://getbootstrap.com/css/?#horizontal-form-group-sizes">Horizontal Form Group Sizes</a>, too.</p>

			<form class="form-horizontal">
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label" for="formGroupInputLarge">Large label</label>

					<div class="col-sm-5">
						<input class="form-control" type="text" id="formGroupInputLarge" placeholder="Large input">
					</div>

					<div class="col-sm-5">
						<select id="select2-button-addons-single-input-group-sm" class="form-control js-data-example-ajax">
							<option value="2126244" selected="selected">twbs/bootstrap</option>
						</select>
					</div>
				</div>

				<div class="form-group form-group-sm">
					<label class="col-sm-2 control-label" for="formGroupInputSmall">Small label</label>

					<div class="col-sm-5">
						<input class="form-control" type="text" id="formGroupInputSmall" placeholder="Small input">
					</div>

					<div class="col-sm-5">
						<select id="select2-button-addons-single-input-group-sm" class="form-control js-data-example-ajax" dir="rtl">
							<option value="2126244" selected="selected">twbs/bootstrap</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<select id="select2-button-addons-single-input-group-sm" class="form-control js-data-example-ajax" multiple>
							<option value="2126244" selected="selected">twbs/bootstrap</option>
							<option value="3620194" selected="selected">select2/select2</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Password</label>

					<div class="col-sm-10">
						<input type="password" class="form-control" id="inputPassword3" placeholder="Password">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox"> Remember me
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Sign in</button>
					</div>
				</div>
			</form>

			<div class="page-header">
				<h1 id="inline-forms">
					Inline Forms
				</h1>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<form class="form-inline">
						<div class="form-group">
							<label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
							<div class="input-group">
								<div class="input-group-addon">$</div>
								<select class="form-control select2-single">
									<option></option>
									<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

								</select>
								<div class="input-group-addon">.00</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Transfer cash</button>
					</form>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<form class="form-inline">
						<div class="form-group">
							<label class="sr-only" for="exampleInputEmail3">Email address</label>
							<input type="email" class="form-control" id="exampleInputEmail3" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label class="sr-only" for="exampleInputPassword3">Password</label>
							<input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
						</div>
						<select class="form-control select2-single">
							<option></option>
							<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

						</select>
						<div class="checkbox">
							<label>
								<input type="checkbox"> Remember me
							</label>
						</div>
						<button type="submit" class="btn btn-default">Sign in</button>
					</form>
				</div>
			</div>

			<div class="page-header">
				<h1 id="button-addons">
					Button Addons
				</h1>
			</div>

			<p>Tests for Select2 widgets used in context with Bootstrap's <a href="http://getbootstrap.com/components/#input-groups-buttons">Button Addons</a>.</p>

			<div class="row">
				<div class="col-md-7">
					<label for="select2-button-addons-single-input-group-sm" class="control-label">Select2 custom data load</label>
					<div class="input-group input-group-sm">
						<div class="input-group-btn">
							<button class="btn btn-default" type="button" data-select2-open="select2-button-addons-single-input-group-sm">
								State
							</button>
						</div>
						<select id="select2-button-addons-single-input-group-sm" class="form-control js-data-example-ajax" dir="rtl">
							<option value="2126244" selected="selected">twbs/bootstrap</option>
						</select>
					</div>
				</div>
				<div class="col-md-5">
					<label for="select2-button-addons-multiple-input-group-sm" class="control-label">col-md-5</label>
					<div class="input-group input-group-sm">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" data-select2-open="select2-button-addons-multiple-input-group-sm">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
						<select id="select2-button-addons-multiple-input-group-sm" class="form-control select2-multiple" multiple>
							<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

						</select>
					</div>
				</div>
			</div>



			<div class="row">
				<div class="col-md-7">
					<label for="select2-button-addons-single-input-group" class="control-label">Select2 custom data load</label>
					<div class="input-group">
						<div class="input-group-btn">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								Action <span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="#">Action</a></li>
								<li><a href="#">Another action</a></li>
								<li><a href="#">Something else here</a></li>
								<li class="divider"></li>
								<li><a href="#">Separated link</a></li>
							</ul>
						</div>
						<select id="select2-button-addons-single-input-group" class="form-control js-data-example-ajax">
							<option value="3620194" selected="selected">select2/select2</option>
						</select>
					</div>
				</div>
				<div class="col-md-5">
					<label for="select2-input-group-append" class="control-label">col-md-5</label>
					<div class="input-group has-warning">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" data-select2-open="select2-input-group-append">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
						<select id="select2-input-group-append" class="form-control select2-multiple" multiple>
							<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

						</select>
					</div>
				</div>
			</div>



			<div class="row">
				<div class="col-md-7">
					<label for="select2-button-addons-single-input-group-lg" class="control-label">Select2 custom data load</label>
					<div class="input-group input-group-lg">
						<select id="select2-button-addons-single-input-group-lg" class="form-control js-data-example-ajax" multiple>
							<option value="2126244" selected="selected">twbs/bootstrap</option>
							<option value="3620194" selected="selected">select2/select2</option>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" data-select2-open="select2-button-addons-single-input-group-lg">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
				</div>
				<div class="col-md-5">
					<label for="select2-button-addons-multi-input-group-lg" class="control-label">col-md-5</label>
					<div class="input-group input-group-lg">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" data-select2-open="select2-button-addons-multi-input-group-lg">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
						<select id="select2-button-addons-multi-input-group-lg" class="form-control select2-multiple" multiple>
							<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

						</select>
					</div>
				</div>
			</div>

			<div class="page-header">
				<h1 id="disabled-inputs">Disabled inputs and options</h1>
			</div>

			<p>The theme applies Bootstrap's styles for <a href="http://getbootstrap.com/css/#forms-control-states">disabled input elements</a> and for disabled dropdown options to the Select2 widgets and its options. Also see Select2's documentation on its "<a href="https://select2.github.io/examples.html#disabled">Disabled mode</a>".</p>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="select2-disabled-inputs-single" class="control-label">Select2 single</label>
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox">
							</span>
							<select id="select2-disabled-inputs-single" class="form-control select2-single" disabled>
								<option></option>
								<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

							</select>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="select2-disabled-inputs-multiple" class="control-label">Select2 multiple</label>
						<div class="input-group">
							<span class="input-group-addon">
								<input type="checkbox" checked>
							</span>
							<select id="select2-disabled-inputs-multiple" class="form-control select2-multiple" multiple>
								<option></option>
								<optgroup label="Alaskan/Hawaiian Time Zone">
	<option value="AK">Alaska</option>
	<option value="HI" disabled="disabled">Hawaii</option>
</optgroup>
<optgroup label="Pacific Time Zone">
	<option value="CA">California</option>
	<option value="NV">Nevada</option>
	<option value="OR">Oregon</option>
	<option value="WA">Washington</option>
</optgroup>
<optgroup label="Mountain Time Zone">
	<option value="AZ">Arizona</option>
	<option value="CO">Colorado</option>
	<option value="ID">Idaho</option>
	<option value="MT">Montana</option><option value="NE">Nebraska</option>
	<option value="NM">New Mexico</option>
	<option value="ND">North Dakota</option>
	<option value="UT">Utah</option>
	<option value="WY">Wyoming</option>
</optgroup>
<optgroup label="Central Time Zone">
	<option value="AL">Alabama</option>
	<option value="AR">Arkansas</option>
	<option value="IL">Illinois</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="OK">Oklahoma</option>
	<option value="SD">South Dakota</option>
	<option value="TX">Texas</option>
	<option value="TN">Tennessee</option>
	<option value="WI">Wisconsin</option>
</optgroup>
<optgroup label="Eastern Time Zone">
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="IN">Indiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="OH">Ohio</option>
	<option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
	<option value="VT">Vermont</option><option value="VA">Virginia</option>
	<option value="WV">West Virginia</option>
</optgroup>
<option value="TNOGZ" disabled="disabled">The No Optgroup Zone</option>
<option value="TPZ">The Panic Zone</option>
<option value="TTZ">The Twilight Zone</option>

							</select>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="footer">
	<div class="container">
		<ul class="footer-links">
	<li class="version"><span class="hidden-xs">Currently</span> v0.1.0-beta.10</li>
	<li>&middot;</li>
	<li><a href="https://github.com/select2/select2-bootstrap-theme">GitHub</a></li>
	<li>&middot;</li>
	<li><a href="https://github.com/select2/select2-bootstrap-theme#readme">Readme</a></li>
</ul>


		<small>
			<a href="http://getbootstrap.com">Bootstrap</a> is a front-end framework for fast, sleek, and mobile-first web development.<br>
			<a href="https://select2.github.io"><img src="/images/logo.png"> Select2</a> is a jQuery based replacement for select boxes.
		</small>
	</div>
</div>


		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                <script src="js/cdnjs.js"></script>

		<script src="js/bootstrap.min.js"></script>
                <script src="js/anchore.js"></script>
		<script>
			anchors.options.placement = 'left';
			anchors.add('.container h1, .container h2, .container h3, .container h4, .container h5');

			// Set the "bootstrap" theme as the default theme for all Select2
			// widgets.
			//
			// @see https://github.com/select2/select2/issues/2927
			$.fn.select2.defaults.set( "theme", "bootstrap" );

			var placeholder = "Select a State";

			$( ".select2-single, .select2-multiple" ).select2( {
				placeholder: placeholder,
				width: null,
				containerCssClass: ':all:'
			} );

			$( ".select2-allow-clear" ).select2( {
				allowClear: true,
				placeholder: placeholder,
				width: null,
				containerCssClass: ':all:'
			} );

			// @see https://select2.github.io/examples.html#data-ajax
			function formatRepo( repo ) {
				if (repo.loading) return repo.text;

				var markup = "<div class='select2-result-repository clearfix'>" +
					"<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
					"<div class='select2-result-repository__meta'>" +
						"<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

				if ( repo.description ) {
					markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
				}

				markup += "<div class='select2-result-repository__statistics'>" +
							"<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-flash'></span> " + repo.forks_count + " Forks</div>" +
							"<div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-star'></span> " + repo.stargazers_count + " Stars</div>" +
							"<div class='select2-result-repository__watchers'><span class='glyphicon glyphicon-eye-open'></span> " + repo.watchers_count + " Watchers</div>" +
						"</div>" +
					"</div></div>";

				return markup;
			}

			function formatRepoSelection( repo ) {
				return repo.full_name || repo.text;
			}

			$( ".js-data-example-ajax" ).select2({
				width : null,
				containerCssClass: ':all:',
				ajax: {
					url: "https://api.github.com/search/repositories",
					dataType: 'json',
					delay: 250,
					data: function (params) {
						return {
							q: params.term, // search term
							page: params.page
						};
					},
					processResults: function (data, params) {
						// parse the results into the format expected by Select2
						// since we are using custom formatting functions we do not need to
						// alter the remote JSON data, except to indicate that infinite
						// scrolling can be used
						params.page = params.page || 1;

						return {
							results: data.items,
							pagination: {
								more: (params.page * 30) < data.total_count
							}
						};
					},
					cache: true
				},
				escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
				minimumInputLength: 1,
				templateResult: formatRepo,
				templateSelection: formatRepoSelection
			});

			$( "button[data-select2-open]" ).click( function() {
				$( "#" + $( this ).data( "select2-open" ) ).select2( "open" );
			});

			$( ":checkbox" ).on( "click", function() {
				$( this ).parent().nextAll( "select" ).prop( "disabled", !this.checked );
			});

			// copy Bootstrap validation states to Select2 dropdown
			//
			// add .has-waring, .has-error, .has-succes to the Select2 dropdown
			// (was #select2-drop in Select2 v3.x, in Select2 v4 can be selected via
			// body > .select2-container) if _any_ of the opened Select2's parents
			// has one of these forementioned classes (YUCK! ;-))
			$( ".select2-single, .select2-multiple, .select2-allow-clear, .js-data-example-ajax" ).on( "select2:open", function() {
				if ( $( this ).parents( "[class*='has-']" ).length ) {
					var classNames = $( this ).parents( "[class*='has-']" )[ 0 ].className.split( /\s+/ );

					for ( var i = 0; i < classNames.length; ++i ) {
						if ( classNames[ i ].match( "has-" ) ) {
							$( "body > .select2-container" ).addClass( classNames[ i ] );
						}
					}
				}
			});
		</script>
	</body>
</html>


