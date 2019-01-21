import { Component, OnInit } from '@angular/core';
import { ApiService } from '../api.service';
import { ActivatedRoute, Router } from '@angular/router';
import { UserModel } from '../user/user-model';
import { MatSnackBar } from '@angular/material';

@Component({
  selector: 'app-user-view',
  templateUrl: './user-view.component.html',
  styleUrls: ['./user-view.component.scss']
})
export class UserViewComponent implements OnInit {

  public loading:boolean = false;
  public user:UserModel;

  constructor(
    private api:ApiService,
    private router:Router,
    private route: ActivatedRoute,
    private snackBar: MatSnackBar
  ) { }

  ngOnInit() {
    this.route.paramMap.subscribe(this.loadUser);
  }

  private loadUser = params => {
    let userId = +params.get('id');
  
    if (!userId) {
      return;
    }

    this.loading = true;
    this.api.getUser(userId).subscribe((user:UserModel) => {
      this.user = user;
    }, (error: any) => {
      this.loading = false;
      if (error.status === 404) {
        this.displayMesasge('User not found.');
      } else {
        this.displayMesasge('Error! Code: ' + error.status);
      }
    }, () => {
      this.loading = false;
    });
  };

  private displayMesasge(message:string) {
    this.snackBar.open(message, null, {
      duration: 2000
    });
  };
}
