import { Component } from '@angular/core';
import { Order } from './order';

import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title:string = 'Reciplz';
  quote:string = '"One cannot think well, love well, sleep well, if one has not dined well."';
  changed:boolean = false;
  suggestion:string = '';
  suggestion2:string[] = ['Salmon', 'Fried Rice', 'Carbonara'];
  suggestions = [
    { name: 'Salmon', id: 1 },
    { name: 'Fried Rice', id: 2 },
    { name: 'Carbonara', id: 3 },
 ];  

  changeSuggestion() {
    if (this.changed == false) {
      this.suggestion = 'Up for some fresh salmon from the sea?';
      this.changed = true;
    } else {
      this.suggestion = 'Go east and make some amazing fried rice!';
      this.changed = false;
    }
  }

  changeQuote(){
    if(this.changed==false){
      this.quote = '"Pull up a chair. Take a taste. Come join us. Life is so endlessly delicious."';
      this.changed = true;
    }
    else{
      this.quote = '"One cannot think well, love well, sleep well, if one has not dined well."';
      this.changed =false;
    }
  }

// create a function when the form submit on Click - redirect
  func(){
    window.location.href = "http://localhost/github/CS4640Angular/search_results.php?submit=submited&search="+this.searchInput;
  }
  checkVal(){
    return true;
  }

  constructor(private http: HttpClient) {   }

  // Let's create a property to store a response from the back end
  // and try binding it back to the view
  responsedata = new Order('');
  searchInput = "";

  orderModel = new Order('');


  confirm_msg = '';
  data_submitted = '';

  confirmOrder(data) {
     console.log(data);
     this.confirm_msg = 'Thank you, your message ' + data.name + 'has been recorded!';

  }


  // Assume we want to send a request to the backend when the form is submitted
  // so we add code to send a request in this function

  onSubmit(form: any): void {
     console.log('You submitted value: ', form);
     this.data_submitted = form;

     // Convert the form data to json format
     let params = JSON.stringify(form);

     // To send a GET request, use the concept of URL rewriting to pass data to the backend
     // this.http.get<Order>('http://localhost/cs4640/inclass11/ngphp-get.php?str='+params)
     // To send a POST request, pass data as an object
     this.http.post<Order>('http://localhost/Github/CS4640Angular/ngphp-post.php', params)
     .subscribe((data) => {
          // Receive a response successfully, do something here
          // console.log('Response from backend ', data);
          this.responsedata = data;     // assign response to responsedata property to bind to screen later
     }, (error) => {
          // An error occurs, handle an error in some way
          console.log('Error ', error);
     })
  }
}
