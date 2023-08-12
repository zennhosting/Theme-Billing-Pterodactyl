import styled from 'styled-components/macro';
import tw from 'twin.macro';

export default styled.div<{ $hoverable?: boolean }>`
    ${tw`flex rounded no-underline text-neutral-200 items-center p-4 border border-transparent transition-colors duration-150 overflow-hidden`};
    background-color: var(--secondary);
    border-radius:10px;

    ${props => props.$hoverable !== false && tw`hover:border-neutral-800`};

    & .icon {
        ${tw`rounded-full bg-neutral-500 p-3`};
    }
`;
