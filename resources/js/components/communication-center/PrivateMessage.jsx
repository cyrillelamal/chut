import React from "react";
import UserPicker from "./UserPicker";
import PrivateMessageForm from "./PrivateMessageForm";
import {sendPrivateMessage} from "../../services/messages";
import {Navigate} from "react-router-dom";

export default class PrivateMessage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            user: null,
            conversationId: null,
        };
    }

    setUser = (user) => {
        this.setState({user});
    }

    send = async (body) => {
        const {user} = this.state;

        if (null !== user) {
            return sendPrivateMessage(user.id, body)
                .then(({data}) =>data['conversation'])
                .then((conversation) => this.setState({conversationId: conversation.id}));
        }

        return new Promise(() => null);
    }

    render() {
        return null === this.redirect ? (
            <>
                <UserPicker handleSelect={this.setUser}/>
                <PrivateMessageForm show={this.show} {...this.user} setUser={this.setUser} send={this.send}/>
            </>
        ) : (<Navigate to={this.redirect}/>);
    }

    get user() {
        return this.state.user ?? {};
    }

    get show() {
        return 0 < Object.keys(this.user).length;
    }

    get redirect() {
        const {conversationId} = this.state;
        return null === conversationId ? null : `/conversations/${conversationId}`
    }
}
