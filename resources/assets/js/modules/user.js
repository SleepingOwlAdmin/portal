module.exports = {
   _object: {
       name: '',
       email: '',
       is_admin: false,
       roles: {
           data: []
       }
   },
    init (user) {
       this._object = user
    },
    getObject () {
        return this._object
    },
    isAdmin () {
        return this._object.is_admin
    },
    isLoggedIn() {
        return _.has(this._object, 'id') && !_.isNull(this._object.id);
    },
    getId () {
        return this.isLoggedIn() && this._object.id || null
    }
}