export default class Gate
{
    /**
     * Initialize a new gate instance.
     *
     * @param  {string|object}  user
     * @return {void}
     */
    constructor(user = 'user')
    {
        this.policies = {};
        this.user = typeof user === 'object' ? user : (window[user] || null);

        const files = require.context('./', true, /Policy\.js$/);
        files.keys().map(key => {
            let name = key.split('/').pop().replace('Policy.js', '').toLowerCase();
            this.policies[name] = new (files(key).default);
        });
    }

    /**
     * Check if the user has a general perssion.
     *
     * @return {bool|void}
     */
    before()
    {
        //
    }

    /**
     * Determine wheter the user can perform the action on the model.
     *
     * @param  {string}  action
     * @param  {object|string}  model
     * @return {bool}
     */
    allow(action, model)
    {
        if (this.before()) {
            return true;
        }

        let type = typeof model === 'object' ? model.model_name : model;

        if (this.user && this.policies.hasOwnProperty(type) && typeof this.policies[type][action] === 'function') {
            return this.policies[type][action](this.user, typeof model === 'object' ? model : null);
        }

        return false;
    }

    /**
     * Determine wheter the user can't perform the action on the model.
     *
     * @param  {string}  action
     * @param  {object}  model
     * @return {bool}
     */
    deny(action, model)
    {
        return ! this.allow(action, model);
    }
}
