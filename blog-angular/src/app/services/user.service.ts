import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { user } from '../models/user';
import { TestBed } from '@angular/core/testing';

@Injectable()
export class UserService {
    constructor(
        public _http: HttpClient
    ) {

    }
    test() {
        return "Hola mundo desde un servicio!!";
    }
}