import React from "react";
import {Nav} from "react-bootstrap";

export default class Navbar extends React.Component {
    handleSelect = (e) => {
        e.preventDefault();
        e.stopPropagation();
    }

    render() {
        return (
            <Nav className="justify-content-end mb-3" onSelect={this.handleSelect}>
                <Nav.Item>
                    <Nav.Link href="/logout">
                        {'Log out'}{/* TODO: i18n */}
                    </Nav.Link>
                </Nav.Item>
            </Nav>
        );
    }
}
