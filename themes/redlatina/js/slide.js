var debSlide = function (args) {
    var slist = document.querySelectorAll(args.selector + " li");
    var slidecont = document.querySelector(args.selector + " ul");
    var total = slist.length;
    var active = 0;
    if (args.auto == null) args.auto = true;
    if (args.responsive == null) args.responsive = true;
    var interval;

    var goingTo = function (number) {
        slist[active].removeAttribute('data-state');
        slist[number].setAttribute('data-state', 'active');
        active = number;
        if (args.callback) args.callback(slist[active]);
        if (args.responsive) slidecont.style.height = slist[active].getAttribute('height');
    };

    var goingNext = function () {
        if (active + 1 < total) goingTo(active + 1);
        else goingTo(0);
    };
    var goingPrev = function () {
        if (active - 1 >= 0) goingTo(active - 1);
        else goingTo(total - 1);
    };

    var start = function () {
        if (interval == null) interval = setInterval(goingNext, args.time || 2000);
    };

    var stop = function () {
        clearInterval(interval);
        interval = null;
    }

    var setAutoHeight = function () {
        slist.forEach(function (i) { i.setAttribute('height', i.offsetHeight + 'px'); });
    };

    if (args.responsive) {
        window.addEventListener('resize', setAutoHeight);
        window.addEventListener('load', setAutoHeight);
    }

    slist[active].setAttribute('data-state', 'active');
    if (args.next) document.querySelector(args.next).addEventListener('click', function () {
        stop(); goingNext(); start();
    });
    if (args.prev) document.querySelector(args.prev).addEventListener('click', function () {
        stop(); goingPrev(); start();
    });
    if (args.auto === true) slist.forEach(function (i) {
        i.addEventListener('mouseover', stop); i.addEventListener('mouseout', start);
    });
    if (args.auto === true) start();

    return {
        goingTo: goingTo,
        next: goingNext,
        prev: goingPrev,
        start: start,
        stop: stop
    };
};


