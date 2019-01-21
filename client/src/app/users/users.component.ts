import { Component, OnInit } from '@angular/core';
import { ApiService } from '../api.service';
import { Router, ActivatedRoute } from '@angular/router';
import { MatSnackBar } from '@angular/material';

@Component({
  selector: 'app-users',
  templateUrl: './users.component.html',
  styleUrls: ['./users.component.scss']
})

export class UsersComponent implements OnInit {
  public loading = false;
  public perPage = 3;
  public users:any = [];
  public page:number = 1;
  public prevUri:string;
  public nextUri:string;

  constructor(
    private router:Router,
    private route: ActivatedRoute,
    private api:ApiService,
    private snackBar: MatSnackBar
    ) { }

  ngOnInit() {
    this.route.paramMap.subscribe(this.loadPageParams);
  }

  public prevPage() {
    this.router.navigate(['/users', (this.page - 1)])
  }

  public nextPage() {
    this.router.navigate(['/users', (this.page + 1)])
  }

  public delete(id:number) {
    this.loading = true;
    this.api.deleteUser(id).subscribe(() => {
      this.displayMesasge('User deleted.');
      this.loadUsersPage();
    }, (error:any) => {
      this.displayMesasge('Unable to delete user. Error code: ' + error.status);
    }, () => {
      this.loading = false;
    });
  }

  private loadPageParams = params => {
    this.page = +params.get('page');
    if (this.page < 1) {
      this.router.navigate(['/users', 1])
      return;
    }
    this.loadUsersPage();
  };

  private load = data => {
    this.users = data.users
    this.prevUri = data.prevUri
    this.nextUri = data.nextUri
    if (!this.users.length && this.page > 1) {
      this.router.navigate(['/users', (this.page - 1)])
    }
  };

  private loadUsersPage() {
    this.prevUri = null;
    this.nextUri = null;
    this.loading = true;

    this.api.getUsersPage(this.page, this.perPage).subscribe(this.load, (error:any) => {
      this.displayMesasge('Error: Unable to get users. Code: ' + error.status);
    }, () => {
      this.loading = false;
    });
  }

  private displayMesasge(message:string) {
    this.snackBar.open(message, null, {
      duration: 2000
    });
  };
}
