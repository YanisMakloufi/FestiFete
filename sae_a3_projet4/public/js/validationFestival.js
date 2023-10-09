function accepterFestival(event) {
    let festival = event.target.closest(".festival");

    let xhr = new XMLHttpRequest();

    let URL = Routing.generate('accepterFestival', {"id": event.target.dataset.festivalId});

    xhr.open("POST", URL, true);
    xhr.onload = function () {
        festival.remove();
        //xhr.status permet d'accèder au code de réponse HTTP (200, 204, 403, 404, etc...)
    };
    xhr.send(null);
}

function refuserFestival(event) {
    let festival = event.target.closest(".festival");

    let xhr = new XMLHttpRequest();

    let URL = Routing.generate('refuserFestival', {"id": event.target.dataset.festivalId});

    xhr.open("DELETE", URL, true);
    xhr.onload = function () {
        festival.remove();
        //xhr.status permet d'accèder au code de réponse HTTP (200, 204, 403, 404, etc...)
    };
    xhr.send(null);
}

let boutonsRefuser = document.getElementsByClassName("refuser");
let boutonsAccepter = document.getElementsByClassName("accepter");
Array.from(boutonsRefuser).forEach(function (button) {
    button.addEventListener("click", refuserFestival);
});
Array.from(boutonsAccepter).forEach(function (button) {
    button.addEventListener("click", accepterFestival);
});