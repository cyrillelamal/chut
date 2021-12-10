import React from "react";
import {withTranslation} from "react-i18next";

class Header extends React.Component {
    render() {
        const {t} = this.props;

        return (
            <header className="pb-3 mb-4 border-bottom">
                <a href="/" className="d-flex align-items-center text-dark text-decoration-none">
                    <span className="fs-4">{t('app.name')}</span>
                </a>
            </header>
        );
    }
}

export default withTranslation()(Header);
