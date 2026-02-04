/**
 * Check if a dataset property of an element is true
 * @param element The element to check
 * @param name The value within the dataset
 * @param defaultValue The fallback value
 */
export function dataBool(
  element: HTMLElement,
  name: string,
  defaultValue = false,
): boolean {
  const value = element.dataset[name];

  if (value === undefined) return defaultValue;

  return value === '' || value === 'true' || value === '1';
}