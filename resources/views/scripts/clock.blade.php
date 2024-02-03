<script>
    window.addEventListener("load", () => {
       clock();
       function clock() {
          const today = new Date();

          // Get day of the week
          const daysOfWeek = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
          const dayOfWeek = daysOfWeek[today.getDay()];

          // Get month
          const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
          const month = months[today.getMonth()];

          // Get day of the month
          const dayOfMonth = today.getDate();

          // Get time components
          const hours = today.getHours();
          const minutes = today.getMinutes();
          const seconds = today.getSeconds();

          // Determine AM or PM
          const ampm = hours >= 12 ? "PM" : "AM";

          // Convert hours to 12-hour format
          const hour = hours % 12 || 12;

          // Add '0' to minute & second when they are less than 10
          const minute = minutes < 10 ? "0" + minutes : minutes;
          const second = seconds < 10 ? "0" + seconds : seconds;

          // Combine day of the month, month, day of the week, time, and AM/PM designation
          const digitalTime = dayOfWeek + ' ' + hour + ":" + minute + ":" + second + ' ' + ampm;

          // Print the digital time to the DOM
          document.getElementById("time").innerHTML = digitalTime;
          setTimeout(clock, 1000);
       }
    });
</script>
