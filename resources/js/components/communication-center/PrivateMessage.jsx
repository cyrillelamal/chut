import React from "react";
import UserPicker from "./UserPicker";
import PrivateMessageForm from "./PrivateMessageForm";
import {sendPrivateMessage} from "../../services/messages";

export default class PrivateMessage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            user: null,
        };
    }

    setUser = (user) => {
        this.setState({user});
    }

    send = async (body) => {
        const {user} = this.state;

        if (null !== user) {
            return sendPrivateMessage(user.id, body)
                .then(console.log); // TODO: redirect to conversation
        }

        return new Promise(() => null);
    }

    render() {
        return (
            <>
                <UserPicker handleSelect={this.setUser}/>
                <PrivateMessageForm show={this.show} {...this.user} setUser={this.setUser} send={this.send}/>
            </>
        );
    }

    get user() {
        return this.state.user ?? {};
    }

    get show() {
        return 0 < Object.keys(this.user).length;
    }
}
