import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { UserModel } from '../user/user-model';
import { ApiService } from '../api.service';
import { Router, ActivatedRoute } from '@angular/router';
import { UserFormErrors } from './user-form-errors';
import { MatSnackBar } from '@angular/material';

@Component({
  selector: 'app-user-create',
  templateUrl: './user-create.component.html',
  styleUrls: ['./user-create.component.scss']
})

export class UserCreateComponent implements OnInit {
  public loading:boolean = false;
  public form:FormGroup;
  public formErrors:UserFormErrors = new UserFormErrors();
  public user:UserModel;

  constructor(
    private formBuilder:FormBuilder,
    private api:ApiService,
    private router:Router,
    private route: ActivatedRoute,
    private snackBar: MatSnackBar
    ) { }
  
  ngOnInit() {
    this.form = this.createFromGroup();
    this.route.paramMap.subscribe(this.loadUser);
  }

  public onSubmit() {
    if (!this.form.valid) {
      return;
    }

    const userData: UserModel = Object.assign({}, this.form.value);
    
    this.loading = true;

    if (!this.user) {
      this.api.createUser(userData).subscribe(this.success, this.error, this.finally);
    } else {
      this.api.updateUser(this.user.id, userData).subscribe(this.success, this.error, this.finally);
    }
  }

  private finally = () => {
    this.loading = false;
  };

  private success = (user:UserModel) => {
    this.router.navigate(['/user', user.id])
  };

  private error = (error: any) => {
    this.loading = false;
  
    if (error.status === 400) {
      this.mapErrors(error);
    } else {        
      this.displayError(error.error.message || 'Unknown');
    }
  };

  private loadUser = params => {
    let userId = +params.get('id');
    if (!userId) {
      return;
    }

    this.api.getUser(userId).subscribe((user:UserModel) => {
      this.user = user;
      this.form = this.createFromGroup();
    });
  };

  private displayError(error:string) {
    this.snackBar.open('Error: ' + error, null, {
      duration: 2000
    });
  };

  private createFromGroup() :FormGroup {
    return this.formBuilder.group({
      name: [this.user ? this.user.name : '', [
        Validators.required
      ]],
      username: [this.user ? this.user.username : '', [
        Validators.required
      ]],
      phone: [this.user ? this.user.phone : '', [
        Validators.required
      ]],
      email: [this.user ? this.user.email : '', [
        Validators.required,
        Validators.email
      ]],
      website: [this.user ? this.user.website : '', [
        Validators.required
      ]],
      address: this.formBuilder.group({
        street: [this.user ? this.user.address.street : '', [
          Validators.required
        ]],
        suite: [this.user ? this.user.address.suite : '', []],
        city: [this.user ? this.user.address.city : '', [
          Validators.required
        ]],
        zipcode: [this.user ? this.user.address.zipcode : '', [
          Validators.required
        ]],
        geo: this.formBuilder.group({
          lng: [this.user ? this.user.address.geo.lng : '', []],
          lat: [this.user ? this.user.address.geo.lat : '', []]
        })
      }),
      company: this.formBuilder.group({
        name: [this.user ? this.user.company.name : '', [
          Validators.required
        ]],
        catchPhrase: [this.user ? this.user.company.catchPhrase : '', []],
        bs: [this.user ? this.user.company.bs : '', []]
      })
    });
  }

  private mapErrors(errors:any) {
      let formErrors = errors.error.errors;

      let userErrors = formErrors.children;

      this.formErrors.name = userErrors.name.errors || [];
      if (this.formErrors.name.length) {
        this.form.get('name').setErrors(['api']);
      }

      this.formErrors.username = userErrors.username.errors || [];
      if (this.formErrors.username.length) {
        this.form.get('username').setErrors(['api']);
      }

      this.formErrors.email = userErrors.email.errors || [];
      if (this.formErrors.email.length) {
        this.form.get('email').setErrors(['api']);
      }

      this.formErrors.phone = userErrors.phone.errors || [];
      if (this.formErrors.phone.length) {
        this.form.get('phone').setErrors(['api']);
      }

      this.formErrors.website = userErrors.website.errors || [];
      if (this.formErrors.website.length) {
        this.form.get('website').setErrors(['api']);
      }

      let addressErrors = userErrors.address.children;

      this.formErrors.address.street = addressErrors.street.errors || [];
      if (this.formErrors.address.street.length) {
        this.form.get('address').get('street').setErrors(['api']);
      }
    
      this.formErrors.address.suite = addressErrors.suite.errors || [];
      if (this.formErrors.address.suite.length) {
        this.form.get('address').get('suite').setErrors(['api']);
      }

      this.formErrors.address.city = addressErrors.city.errors || [];
      if (this.formErrors.address.city.length) {
        this.form.get('address').get('city').setErrors(['api']);
      }

      this.formErrors.address.zipcode = addressErrors.zipcode.errors || [];
      if (this.formErrors.address.zipcode.length) {
        this.form.get('address').get('zipcode').setErrors(['api']);
      }

      let addressGeoErrors = addressErrors.geo.children;

      this.formErrors.address.geo.lat = addressGeoErrors.lat.errors || [];
      if (this.formErrors.address.geo.lat.length) {
        this.form.get('address').get('geo').get('lat').setErrors(['api']);
      }

      this.formErrors.address.geo.lng = addressGeoErrors.lng.errors || [];
      if (this.formErrors.address.geo.lng.length) {
        this.form.get('address').get('geo').get('lng').setErrors(['api']);
      }

      let companyErrors = userErrors.company.children;

      this.formErrors.company.name = companyErrors.name.errors || [];
      if (this.formErrors.company.name.length) {
        this.form.get('company').get('name').setErrors(['api']);
      }

      this.formErrors.company.catchPhrase = companyErrors.catchPhrase.errors || [];
      if (this.formErrors.company.catchPhrase.length) {
        this.form.get('company').get('catchPhrase').setErrors(['api']);
      }

      this.formErrors.company.bs = companyErrors.bs.errors || [];
      if (this.formErrors.company.bs.length) {
        this.form.get('company').get('bs').setErrors(['api']);
      }
  }
}
