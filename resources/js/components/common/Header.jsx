import React from "react";

export default class Header extends React.Component {
    render() {
        return (
            <header className="pb-3 mb-4 border-bottom">
                <a href="/" className="d-flex align-items-center text-dark text-decoration-none">
                    <span className="fs-4">{'chut'}{/* TODO: i18n */}</span>
                </a>
            </header>
        );
    }
}
