/*
 * @crmleaf/epfo-penalty-calculator - a re-export, not a reimplementation.
 *
 * The arithmetic lives once, in @crmleaf/payroll-js, so a slab change cannot
 * land in one package and miss another. This package exists so a project that
 * only wants EPFO Penalty Calculator can install only EPFO Penalty Calculator and still get the
 * identical function it would have got from the suite.
 */

export { epfoPenalty, epfoPenalty as calculate, Money } from '@crmleaf/payroll-js';

export { epfoPenalty as default } from '@crmleaf/payroll-js';
