import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { MatSnackBar } from '@angular/material';
import { Router } from '@angular/router';
import { ApiService } from '../api.service';
import { ImportModel } from './import-model';
import { HttpClient } from '@angular/common/http';
import { UserModel } from '../user/user-model';

@Component({
  selector: 'app-user-import',
  templateUrl: './user-import.component.html',
  styleUrls: ['./user-import.component.scss']
})
export class UserImportComponent implements OnInit {

  private base:string = 'https://jsonplaceholder.typicode.com/users/'; 

  public loading:boolean = false;
  public importForm:FormGroup;

  constructor(
    private router:Router,
    private rest:ApiService,
    private formBuilder:FormBuilder,
    private http: HttpClient,
    private snackBar: MatSnackBar
  ) {
    this.importForm = this.formBuilder.group({
      uri: [this.randomUri(), [
        Validators.required,
        Validators.pattern(/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/)
      ]]
    });
  }

  ngOnInit() {
  }

  public randomizeUri() {
    this.importForm.get('uri').setValue(this.randomUri());
  }

  private randomUri(): string {
    return this.base + (Math.floor(Math.random() * 10) + 1);
  }

  public onSubmit() {
    if (!this.importForm.valid) {
      return;
    }

    const result: ImportModel = Object.assign({}, this.importForm.value);

    this.loading = true;

    this.http.get(result.uri).subscribe((user: UserModel) => {
      delete user.id;
      this.rest.createUser(user).subscribe(
        (user:UserModel) => {
          this.router.navigate(['/user', user.id])
        },
        (error: any) => {
          this.loading = false;
          let message = error.error.message || 'Unknown';
          if (message === 'Validation Failed') {
            message += '. User already exists?';
          }
          this.displayError(message);
        }, () => {
          this.loading = false;
        });
    }, (error: any) => {
        this.loading = false;
        this.displayError('Unable to get resource!');
    }, () => {
      this.loading = false;
    });
  }

  private displayError(error:string) {
    this.snackBar.open('Error: ' + error, null, {
      duration: 2000
    });
  };

  
}
