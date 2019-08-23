import { Component, OnInit } from '@angular/core';
import { user } from '../../models/user';

@Component({
  selector: 'register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  public page_title: string;
  public user: user;


  constructor() {
    this.page_title = 'Regístrate';
    this.user = new user(1, '', '', 'ROLE_USER', '', '', '', '');

  }


  ngOnInit() {
    console.log('Componente de registro lanzado!');
  }

  onSubmit(form) {
    console.log(this.user);
    form.reset();
  }


}
