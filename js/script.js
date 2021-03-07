let todayDate = document.querySelector('[name="date"]');
todayDate.addEventListener('change',function (e) {
    let times = document.querySelectorAll('[name="time"]'),
    now = new Date(),
    hours = Number(now.getHours()),
    minutes = Number(now.getMinutes());
    times.forEach(function (time,index) {
        let minutesHere = Number(time.value.substr(-2)),
            hoursHere = Number(time.value.substr(0,2));
        if (hoursHere < hours || (hoursHere == hours && minutesHere < minutes)) {
            let label = time.nextElementSibling;
            label.classList.toggle('hidden');
        }
    });
});