import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
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
    private _userService: UserService,
    private _router: Router,
    private _route: ActivatedRoute
  ) {
    this.page_title = 'Identifícate';
    this.user = new user(1, '', '', 'ROLE_USER', '', '', '', '');
  }

  ngOnInit() {

    //se ejecuta siempre y cierra sesion solo cuando le llega el parametro sure por la url
    this.logout();
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
              //PERSISTIR DATOS USUARIO IDENTIFICADO
              console.log(this.token);
              console.log(this.identity);

              localStorage.setItem('token', this.token);
              localStorage.setItem('identity', JSON.stringify(this.identity));

              //redireccion a inicio
              this._router.navigate(['inicio']);
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

  logout() {
    this._route.params.subscribe(params => {
      let logout = +params['sure'];

      if (logout == 1) {
        localStorage.removeItem('identity');
        localStorage.removeItem('token');

        this.identity = null;
        this.token = null;

        //redireccion a inicio
        this._router.navigate(['inicio']);

      }
    });
  }

}
