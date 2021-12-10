import React from "react";
import UserPicker from "./UserPicker";
import {Navigate} from "react-router-dom";
import SelectedUserList from "./SelectedUserList";
import {startConversation} from "../../services/conversations";

export default class PublicConversation extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            users: [],
            conversationId: null,
        };
    }

    setUsers = (users) => {
        this.setState({users});
    }

    appendUser = (user) => {
        this.setState(
            (state) => {
                const {users} = state;
                return users.find(u => u.id === user.id) // selected
                    ? {}
                    : {users: [...state.users, user]};
            }
        );
    }

    submit = () => {
        const ids = this.users.map(u => u.id);
        startConversation(ids)
            .then(({data}) => data.id)
            .then((conversationId) => this.setState({conversationId})); // redirect
    }

    render() {
        return null === this.redirect ? (
            <>
                {!!this.users.length && (
                    <div className="h-25">
                        <SelectedUserList users={this.users} setUsers={this.setUsers} handleSelect={this.submit}/>
                    </div>
                )}
                <div className={this.users.length ? 'h-75' : 'h-100'}>
                    <UserPicker handleSelect={this.appendUser}/>
                </div>
            </>
        ) : (<Navigate to={this.redirect}/>);
    }

    get users() {
        return this.state.users;
    }

    get redirect() {
        const {conversationId} = this.state;
        return null === conversationId ? null : `/conversations/${conversationId}`
    }
}
