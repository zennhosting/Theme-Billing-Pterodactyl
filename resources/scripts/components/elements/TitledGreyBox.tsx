import React, { memo } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { IconProp } from '@fortawesome/fontawesome-svg-core';
import tw from 'twin.macro';
import isEqual from 'react-fast-compare';
import styled from 'styled-components/macro';

const Box = styled.div`
& {
    background-color: var(--secondary);
    border-radius:10px;
}
& > div {
    background-color: var(--secondary);
    border-radius:10px;
}
`;

interface Props {
    icon?: IconProp;
    title: string | React.ReactNode;
    className?: string;
    children: React.ReactNode;
}

const TitledGreyBox = ({ icon, title, children, className }: Props) => (
    <Box className={className}>
        <div css={tw`py-4 px-5 border-b border-black`}>
            {typeof title === 'string' ? (
                <p css={tw`text-sm uppercase`}>
                    {icon && <FontAwesomeIcon icon={icon} css={tw`mr-2 text-neutral-300`} />}
                    {title}
                </p>
            ) : (
                title
            )}
        </div>
        <div css={tw`py-4 px-5`}>{children}</div>
    </Box>
);

export default memo(TitledGreyBox, isEqual);
