function countdown_clock(year, month, day, hour, minute, second, format)
         {
         //I chose a div as the container for the timer, but
         //it can be an input tag inside a form, or anything
         //who's displayed content can be changed through
         //client-side scripting.
         html_code = '<div id="countdown"></div>';
         
         document.write(html_code);
         
         countdown(year, month, day, hour, minute, second, format);                
         }
         
function countdown(year, month, day, hour, minute, second, format)
         {
         Today = new Date();
         Todays_Year = Today.getFullYear() - 2000;
         Todays_Month = Today.getMonth() + 1;                  
         
         //Convert both today's date and the target date into miliseconds.                           
         Todays_Date = (new Date(Todays_Year, Todays_Month, Today.getDate(), 
                                 Today.getHours(), Today.getMinutes(), Today.getSeconds())).getTime();                                 
         Target_Date = (new Date(year, month, day, hour, minute, second)).getTime();                  
         
         //Find their difference, and convert that into seconds.                  
         Time_Left = Math.round((Target_Date - Todays_Date) / 1000);
         
         if(Time_Left < 0)
            Time_Left = 0;
         
         switch(format)
               {
               case 0:
                    //The simplest way to display the time left.
                    document.all.countdown.innerHTML = Time_Left + ' seconds';
                    break;
               case 1:
                    //Mine.
                    days = Math.floor(Time_Left / (60 * 60 * 24));
                    Time_Left %= (60 * 60 * 24);
                    hours = Math.floor(Time_Left / (60 * 60));
                    Time_Left %= (60 * 60);
                    minutes = Math.floor(Time_Left / 60);
                    Time_Left %= 60;
                    seconds = Time_Left;
                    
                    document.all.countdown.innerHTML = hours + ':';
                    document.all.countdown.innerHTML += minutes + ':';
                    document.all.countdown.innerHTML += seconds;
                    break;
               case 2:
                    //More detailed.
                    days = Math.floor(Time_Left / (60 * 60 * 24));
                    Time_Left %= (60 * 60 * 24);
                    hours = Math.floor(Time_Left / (60 * 60));
                    Time_Left %= (60 * 60);
                    minutes = Math.floor(Time_Left / 60);
                    Time_Left %= 60;
                    seconds = Time_Left;
                    
                    dps = 's'; hps = 's'; mps = 's'; sps = 's';
                    //ps is short for plural suffix.
                    if(days == 1) dps ='';
                    if(hours == 1) hps ='';
                    if(minutes == 1) mps ='';
                    if(seconds == 1) sps ='';
                    
                    document.all.countdown.innerHTML = days + ' day' + dps + ' ';
                    document.all.countdown.innerHTML += hours + ' hour' + hps + ' ';
                    document.all.countdown.innerHTML += minutes + ' minute' + mps + ' and ';
                    document.all.countdown.innerHTML += seconds + ' second' + sps;
                    break;
               default: 
                    document.all.countdown.innerHTML = Time_Left + ' seconds';
               }
               
         //Recursive call, keeps the clock ticking.
         setTimeout('countdown(' + year + ',' + month + ',' + day + ',' + hour + ',' + minute + ',' + second + ',' + format + ');', 1000);
         }