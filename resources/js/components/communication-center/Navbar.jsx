import React from "react";
import {Nav} from "react-bootstrap";
import {withTranslation} from "react-i18next";

class Navbar extends React.Component {
    handleSelect = (e) => {
        e.preventDefault();
        e.stopPropagation();
    }

    render() {
        const {t} = this.props;

        return (
            <Nav className="justify-content-end mb-3" onSelect={this.handleSelect}>
                <Nav.Item>
                    <Nav.Link href="/logout">
                        {t('security.logout')}
                    </Nav.Link>
                </Nav.Item>
            </Nav>
        );
    }
}

export default withTranslation()(Navbar);
