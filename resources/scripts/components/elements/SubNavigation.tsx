import styled from 'styled-components/macro';
import tw, { theme } from 'twin.macro';

const SubNavigation = styled.div`
    ${tw`w-full overflow-x-auto`};

    & > div {
        ${tw`flex items-center text-sm mx-auto`};

        & > a, & > div {
            ${tw`inline-block py-3 text-neutral-300 no-underline whitespace-nowrap transition-all duration-150`};
            margin-right:30px;

            &:hover {
                ${tw`text-neutral-100`};
            }

            &.active {
                ${tw`text-neutral-100`};
                box-shadow: inset 0 -2px var(--primary);
            }
        }
    }
`;

export default SubNavigation;
