import React from "react";
import SelectedUser from "./SelectedUser";
import {Button} from "react-bootstrap";

export default class SelectedUserList extends React.Component {
    removeUser = (id) => {
        const users = this.props.users.filter(u => u.id !== id);

        this.props.setUsers && this.props.setUsers(users);
    }

    handleClick = (e) => {
        e.preventDefault();
        e.stopPropagation();

        this.props.handleSelect && this.props.handleSelect(this.props.users);
    }

    user = (u) => <SelectedUser key={u.id} {...u} removeUser={this.removeUser}/>

    render() {
        return (
            <div className="overflow-auto h-100">
                <div className="d-flex flex-row">
                    <div className="flex-grow-1">
                        {this.props.users.map(this.user)}
                    </div>
                    <div className="px-2 pt-3">
                        <Button variant="success" type="submit" onClick={this.handleClick}>
                            {'Create'}{/* TODO: i18n */}
                        </Button>
                    </div>
                </div>
            </div>
        );
    }
}
