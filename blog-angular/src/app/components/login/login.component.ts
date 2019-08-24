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
  public status: string;
  public token;
  public identity;

  constructor(
    private _userService: UserService
  ) {
    this.page_title = 'Identifícate';
    this.user = new user(1, '', '', 'ROLE_USER', '', '', '', '');
  }

  ngOnInit() {

  }

  onSubmit(form) {
    this._userService.signup(this.user).subscribe(
      response => {
        //token
        if (response.status != 'error') {
          this.status = 'success';
          this.token = response;

          //objeto usuario identificado
          this._userService.signup(this.user, true).subscribe(
            response => {
              this.identity = response;

              console.log(this.token);
              console.log(this.identity);
            },
            error => {
              this.status = 'error';
              console.log(<any>error);
            }
          );

        } else {
          this.status = 'error';
        }
      },

      error => {
        this.status = 'error';
        console.log(<any>error);
      }
    );
  }

}
