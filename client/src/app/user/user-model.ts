class UserAddressGeo {
    lat: number;
    lng: number;
}

class UserAddress {
    street: string;
    suite: string;
    city: string;
    zipcode: string;
    geo: UserAddressGeo;
}

class UserCompany {
    name: string;
    catchPhrase: string;
    bs: string;
}

export class UserModel {
    id: number;
    name: string;
    username: string;
    email: string;
    phone: string;
    website: string;
    address: UserAddress;
    company: UserCompany;
}