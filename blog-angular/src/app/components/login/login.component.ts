import { Component, OnInit } from '@angular/core';
import { user } from '../../models/user';
import { UserService } from '../../services/user.service';

@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: [UserService]
})
export class LoginComponent implements OnInit {

  public page_title: string;
  public user: user;

  constructor(
    private _userService: UserService
  ) {
    this.page_title = 'Identifícate';
    this.user = new user(1, '', '', 'ROLE_USER', '', '', '', '');
  }

  ngOnInit() {

  }

  onSubmit(form) {
    console.log(this.user);
  }

}
