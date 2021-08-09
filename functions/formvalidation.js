"use strict";

let loginform = document.forms.login;
if (!(typeof(loginform) === "undefined")) {
	loginform.addEventListener("submit", validateLogin);
}

function validateLogin() {
	let message = document.getElementById("SessionMessage");
	message.innerHTML = "";
	let email = loginform.email.value;
	let password = loginform.password.value;
	message.style.display = "none";
	if (email == "") {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please enter an email Address</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	} else if (!email.includes("@")) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Invaild Email Address: Email must have an @ symbol</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	} else if (email.includes("&") || email.includes("'") || email.includes('"') || email.includes("<") || email.includes(">")) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Invaild Characters Used in email field (& ' " + '"' + " < >)</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (password == "") {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please enter your Password</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	} else if (password.includes("&") || password.includes("'") || password.includes('"') || password.includes("<") || password.includes(">")) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Invaild Characters Used in password field (& ' " + '"' + " < >)</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
}

let registerform = document.forms.register;
if (!(typeof(registerform) === "undefined")) {
	registerform.addEventListener("submit", validateRegistration);
}

function validateRegistration() {
	let message = document.getElementById("SessionMessage");
	message.innerHTML = "";
	let email = registerform.email.value;
	let firstname = registerform.firstname.value;
	let lastname = registerform.lastname.value;
	let address = registerform.address.value;
	let password = registerform.password.value;
	let confirm_password = registerform.confirm_password.value;
	let title = registerform.title.value;
	let dateofbirth = registerform.dateofbirth.value;
	let phonenumber = registerform.phonenumber.value;
	let allInputsString = "" + email + firstname + lastname + address + password + confirm_password + title + dateofbirth + phonenumber;
	message.style.display = "none";
	if (email == "") {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please enter your Email Address</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	} else if (!email.includes("@")) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Invaild Email Address: Email must have an @ symbol</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (allInputsString.includes("&") || allInputsString.includes("'") || allInputsString.includes('"') || allInputsString.includes("<") || allInputsString.includes(">")) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Invaild Characters were used in the input fields (& ' " + '"' + " < >)</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (firstname == "" || lastname == "") {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please enter your firstname and lastname</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (address == "") {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please enter your Address</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (password == "") {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please enter your Password</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	} else if (password.length < 6) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Password must be at least 6 characters</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (!(password === confirm_password)) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Password and Confirmation Password do not match</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	let phoneinteger = phonenumber.replace(/ /g, "");
	phoneinteger = phoneinteger.replace(/-/g, "");
	if (isNaN(Number(phoneinteger)) || phoneinteger === 0) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Phone Number was invaild please use numbers, spaces and hyphens</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
}

let searchform = document.forms.search;
if (!(typeof(searchform) === "undefined")) {
	searchform.addEventListener("submit", validateSearch);
}

function validateSearch() {
	let message = document.getElementById("SessionMessage");
	message.innerHTML = "";
	message.style.display = "none";
	let triptype = searchform.check;
	let DepartureLocation = searchform.DepartureLocation.value;
	let ArrivalLocation = searchform.ArrivalLocation.value;
	let DepartDate = searchform.DepartDate.value;
	let ReturnDate = searchform.ReturnDate.value;
	let Adults = searchform.Adults.value;
	let Children = searchform.Children.value;
	let Infants = searchform.Infants.value;
	let Bustype = searchform.Bustype.value;
	let Fleet = searchform.fleet.value;
	let Price = searchform.price.value;
	let Order = searchform.order.value;
	let allInputsString = "" + triptype + DepartureLocation + ArrivalLocation + DepartDate + ReturnDate + Adults + Children + Infants + Bustype + Fleet + Price + Order;
	if (allInputsString.includes("&") || allInputsString.includes("'") || allInputsString.includes('"') || allInputsString.includes("<") || allInputsString.includes(">")) {
		message.innerHTML += "<span class='error'>Invaild Characters were used in the input fields (& ' " + '"' + " < >)</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	let ttchosen = false;
	for (let i = 0; i < triptype.length; i++) {
        if (triptype[i].checked) {
            ttchosen = true;
        }
    }
    if (!ttchosen) {
		message.innerHTML += "<span class='error'>Please select a Triptype </span> <br>";
		message.style.display = "block";
        event.preventDefault();
    }
	if (DepartureLocation == "" || ArrivalLocation == "") {
		message.innerHTML += "<span class='error'>Please fill in Departure Location and Arrival Location fields </span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (triptype[1].checked && ReturnDate != "") {
        message.innerHTML += "<span class='error'>There is no need for a return date with a one way trip </span> <br>";
		searchform.ReturnDate.value = "";
		message.style.display = "block";
		event.preventDefault();
    } else if (Date.parse(DepartDate) > Date.parse(ReturnDate)) {
		message.innerHTML += "<span class='error'>The Departure Date must be before the Return Date  </span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (Adults < 0 || Children < 0 || Infants < 0 || Price < 0) {
		message.innerHTML += "<span class='error'>Negative values are not allowed in Price, Adult, Child or Infant fields</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	else if (Adults == 0 && Children == 0) {
		message.innerHTML += "<span class='error'>There must be at least one Adult or Child passager</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
}

let paymentform = document.forms.payment;
if (!(typeof(paymentform) === "undefined")) {
	payment.addEventListener("submit", validatePayment);
}

function validatePayment() {
	let message = document.getElementById("SessionMessage");
	message.innerHTML = "";
	message.style.display = "none";
	let CardNumber = paymentform.CardNumber.value;
	let CardName = paymentform.CardName.value;
	let Expiration = paymentform.Expiration.value;
	let CCV = paymentform.CCV.value;
	let Postcode = paymentform.Postcode.value;
	let PreferredSeat = paymentform.PreferredSeat.value;
	let PreferredSeatSide = paymentform.PreferredSeatSide.value;
	let Adults = paymentform.Adults.value;
	let Children = paymentform.Children.value;
	let Infants = paymentform.Infants.value;
	let TicketID = paymentform.TicketID.value;
	let Loggedon = paymentform.Loggedon.value;
	
	if (Loggedon == "false") {
		paymentform.confirm_password.value = paymentform.password.value;
		registerform = paymentform
		validateRegistration();
		
		if (paymentform.country.value == "") {
			message.innerHTML += "<span class='error'>Please fill in the country field</span> <br>";
			message.style.display = "block";
			event.preventDefault();
		}
	}
	let allInputsString = "" + CardNumber + CardName + Expiration + CCV + Postcode + PreferredSeat + PreferredSeatSide + Adults + Children + Infants + TicketID + Loggedon;
	if (allInputsString.includes("&") || allInputsString.includes("'") || allInputsString.includes('"') || allInputsString.includes("<") || allInputsString.includes(">")) {
		message.innerHTML += "<span class='error'>Invaild Characters were used in the input fields (& ' " + '"' + " < >)</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (CardNumber == "" || CardName == "" || Expiration == "" || CCV == "" || Postcode == "" || Adults == "" || Children == "" || Infants == "" || TicketID == "" || Loggedon == "") {
		message.innerHTML += "<span class='error'>Please fill in all fields</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	
	let cardinteger = CardNumber.replace(/ /g, "");
	cardinteger = cardinteger.replace(/-/g, "");
	if (isNaN(Number(cardinteger))) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please input a vaild card number</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	
	if (Date.parse(new Date()) >= Date.parse(Expiration)) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please enter the card details of a card that has not expired</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	
	if (isNaN(Number(CCV)) || CCV.length != 3) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please input a vaild CCV</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	
	if (isNaN(Number(Postcode)) || Postcode.length != 4) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Please input a vaild Postcode</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	
	if (Adults < 0 || Children < 0 || Infants < 0) {
		message.innerHTML += "<span class='error'>Negative values are not allowed in Adult, Child or Infant fields</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	else if (Adults == 0 && Children == 0) {
		message.innerHTML += "<span class='error'>There must be at least one Adult or Child passager</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
}

let contactform = document.forms.contact;
if (!(typeof(contactform) === "undefined")) {
	contact.addEventListener("submit", validateContact);
}

function validateContact() {
	let message = document.getElementById("SessionMessage");
	message.innerHTML = "";
	let email = contactform.email.value;
	let firstname = contactform.fname.value;
	let lastname = contactform.lname.value;
	let phonenumber = contactform.phonenumber.value;
	let subject = contactform.subject.value;
	let messageC = contactform.message.value;
	let allInputsString = "" + email + firstname + lastname + phonenumber + subject + messageC;
	if (allInputsString.includes("&") || allInputsString.includes("'") || allInputsString.includes('"') || allInputsString.includes("<") || allInputsString.includes(">")) {
		message.innerHTML += "<span class='error'>Invaild Characters were used in the input fields (& ' " + '"' + " < >)</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	if (email == "" || firstname == "" || lastname == "" || phonenumber == "") {
		message.innerHTML += "<span class='error'>Please fill in all fields</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	
	if (!email.includes("@")) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Invaild Email Address: Email must have an @ symbol</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
	
	let phoneinteger = phonenumber.replace(/ /g, "");
	phoneinteger = phoneinteger.replace(/-/g, "");
	if (isNaN(Number(phoneinteger)) || phoneinteger === 0) {
		document.getElementById("SessionMessage").innerHTML += "<span class='error'>Phone Number was invaild please use numbers, spaces and hyphens</span> <br>";
		message.style.display = "block";
		event.preventDefault();
	}
}