export class UserFormErrors {
     id = [];
     name = [];
     username = [];
     email = [];
     phone = [];
     website = [];
     address = {
        street: [],
        suite: [],
        city: [],
        zipcode: [],
        geo: {
            lat: [],
            lng: []
        }
    };
    company = {
        name: [],
        catchPhrase: [],
        bs: []
    };
}
