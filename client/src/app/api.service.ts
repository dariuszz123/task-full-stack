import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { UserModel } from './user/user-model';
import { environment } from './../environments/environment'

const endpoint = environment.api_base;
const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type':  'application/json'
  })
};

@Injectable({
  providedIn: 'root'
})

export class ApiService {

  constructor(private http: HttpClient) {
  }

  public getUsersPage(page:number=1, perPage:number=2) {
    let url = endpoint + '/api/users?offset=' + this.offset(page, perPage) + '&limit=' + perPage;

    return this.http.get(url).pipe(
      map(this.extractData));
  }

  public getUser(id:number) {
    return this.http.get(endpoint + '/api/users/' + id);
  }

  public createUser(data:UserModel) {
    return this.http.post(
      endpoint + '/api/users',
      JSON.stringify(data),
      {
        headers: {'Content-Type': 'application/json'}
      });
  }

  public updateUser(id:number, data:UserModel) {
    return this.http.patch(
      endpoint + '/api/users/'+id,
      JSON.stringify(data),
      {
        headers: {'Content-Type': 'application/json'}
      });
  }

  public deleteUser(id:number) {
    return this.http.delete(endpoint + '/api/users/'+id);
  }

  private offset(page:number=1, perPage:number=2) :number {
    return (page - 1) * perPage;
  }

  private extractData(res: Response) {
    let body = res;
    return body || { };
  }

}