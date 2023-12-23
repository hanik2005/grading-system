$(document).ready(function (){
  let studentToken = $("#userTokenHiddenField").attr("value");
  let studentGrades;
  $.ajax({
    type: "POST",
    url: "retrieve_data.php",
    data: {teacherInfo: true

    },
    success: function (response){
      console.log(response);
    },
    error: function (error){
      console.error(error);
    }
  })
  $.ajax({
    type: "POST",
    url: "retrieve_data.php",
    data: {studentInfo: true,
      studentToken: studentToken

    },
    success: function (response){
      studentGrades = JSON.parse(response); 
      console.log(studentGrades);
      const ctx = $("#performanceChart");
    
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'ahhhhhhh'],
      datasets: [//{
        // label: '# of Votes',
        // data: studentGrades[0],
        // borderWidth: 1
      //},
      //{
        // label: '# of Votes',
        // data: studentGrades[1],
        // borderWidth: 1
      //},
      //{
        // label: '# of Votes',
        // data: studentGrades[2],
        // borderWidth: 1
      //},
      {
        label: '# of Votes',
        data: studentGrades[3],
        borderWidth: 1
      }
    ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
    },
    error: function (error){
      console.error(error);
    }
  })

    
})